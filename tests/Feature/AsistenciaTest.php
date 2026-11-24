<?php

namespace Tests\Feature;

use App\Models\Beneficiario;
use App\Models\EntregaRacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Pruebas del registro de asistencia (RF-03) y del tope municipal de arroz (RF-04).
 */
class AsistenciaTest extends TestCase
{
    use RefreshDatabase;

    private User $voluntario;

    protected function setUp(): void
    {
        parent::setUp();

        $this->voluntario = User::factory()->create(['rol' => 'Voluntario']);

        // El servicio de Kardex descuenta del insumo "Arroz Común", que debe existir
        DB::table('insumos')->insert([
            'nombre_insumo'         => 'Arroz Común',
            'stock_actual'          => 100.00,
            'stock_minimo_alerta'   => 10.00,
            'limite_consumo_diario' => 6.00,
            'unidad_medida'         => 'Kilogramos',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
    }

    private function crearBeneficiario(string $codigo, string $tipo = 'Socio/Cocinera', int $raciones = 2): Beneficiario
    {
        return Beneficiario::create([
            'codigo_beneficiario'  => $codigo,
            'tipo_comensal'        => $tipo,
            'cantidad_integrantes' => 3,
            'raciones_asignadas'   => $raciones,
            'fecha_incorporacion'  => now()->subMonth(),
            'estado'               => true,
        ]);
    }

    /** Simula una asistencia ya registrada hoy (sin pasar por el formulario). */
    private function registrarEntregaHoy(Beneficiario $beneficiario, int $raciones): void
    {
        EntregaRacion::create([
            'beneficiario_id'    => $beneficiario->id,
            'fecha_entrega'      => today()->toDateString(),
            'raciones_retiradas' => $raciones,
            'cuota_cobrada'      => 0,
        ]);
    }

    private function marcar(string $codigo, int $raciones, array $extra = [])
    {
        return $this->actingAs($this->voluntario)->post('/asistencia/registrar', [
            'codigo_beneficiario' => $codigo,
            'raciones_retiradas'  => $raciones,
        ] + $extra);
    }

    public function test_la_cuota_de_socio_se_toma_del_padron(): void
    {
        $this->crearBeneficiario('BEN-TST-001', 'Socio/Cocinera', 2);

        $this->marcar('BEN-TST-001', 2)->assertSessionHasNoErrors();

        $this->assertEquals(10.0, (float) DB::table('entregas_raciones')->value('cuota_cobrada'));
        $this->assertEquals(10.0, (float) DB::table('ingresos_caja')->value('monto'));
    }

    public function test_la_cuota_de_publico_general_se_toma_del_padron(): void
    {
        $this->crearBeneficiario('BEN-TST-002', 'Público General', 2);

        $this->marcar('BEN-TST-002', 2)->assertSessionHasNoErrors();

        $this->assertEquals(16.0, (float) DB::table('entregas_raciones')->value('cuota_cobrada'));
    }

    public function test_ignora_el_tipo_de_comensal_enviado_por_el_formulario(): void
    {
        // Es socio en el padrón: aunque el formulario "diga" Público General, se cobra S/ 5
        $this->crearBeneficiario('BEN-TST-003', 'Socio/Cocinera', 1);

        $this->marcar('BEN-TST-003', 1, ['tipo_comensal' => 'Público General']);

        $this->assertEquals(5.0, (float) DB::table('entregas_raciones')->value('cuota_cobrada'));
    }

    public function test_la_exoneracion_cobra_cero(): void
    {
        $this->crearBeneficiario('BEN-TST-004', 'Público General', 2);

        $encargada = User::factory()->create(['rol' => 'Encargada']);
        $this->actingAs($encargada)->post('/asistencia/registrar', [
            'codigo_beneficiario' => 'BEN-TST-004', 'raciones_retiradas' => 2, 'exonerado' => '1',
        ]);

        $this->assertEquals(0.0, (float) DB::table('entregas_raciones')->value('cuota_cobrada'));
    }

    public function test_rechaza_una_segunda_asistencia_el_mismo_dia(): void
    {
        $this->crearBeneficiario('BEN-TST-005', 'Socio/Cocinera', 2);

        $this->marcar('BEN-TST-005', 1)->assertSessionHasNoErrors();
        $this->marcar('BEN-TST-005', 1)->assertSessionHasErrors('duplicado');

        $this->assertDatabaseCount('entregas_raciones', 1);
        $this->assertDatabaseCount('ingresos_caja', 1);
    }

    public function test_rechaza_raciones_sobre_el_limite_autorizado_por_persona(): void
    {
        $this->crearBeneficiario('BEN-TST-006', 'Socio/Cocinera', 2);

        $this->marcar('BEN-TST-006', 3)->assertSessionHasErrors('limite_persona');

        $this->assertDatabaseCount('entregas_raciones', 0);
    }

    public function test_rechaza_un_codigo_que_no_esta_en_el_padron(): void
    {
        $this->marcar('BEN-NO-EXISTE', 1)->assertSessionHasErrors('error');

        $this->assertDatabaseCount('entregas_raciones', 0);
    }

    public function test_el_tope_municipal_permite_la_racion_40_y_bloquea_la_41(): void
    {
        // 9 comensales ya retiraron 4 raciones cada uno: 36 raciones = 5.40 kg
        for ($i = 1; $i <= 9; $i++) {
            $this->registrarEntregaHoy($this->crearBeneficiario(sprintf('BEN-LIM-%02d', $i), 'Público General', 4), 4);
        }

        // 4 raciones más = 40 raciones = 6.00 kg exactos: está permitido
        $this->crearBeneficiario('BEN-LIM-10', 'Público General', 4);
        $this->marcar('BEN-LIM-10', 4)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('entregas_raciones', ['raciones_retiradas' => 4, 'beneficiario_id' => Beneficiario::where('codigo_beneficiario', 'BEN-LIM-10')->value('id')]);

        // Una ración más superaría los 6.00 kg: se bloquea y no se persiste nada
        $this->crearBeneficiario('BEN-LIM-11', 'Público General', 1);
        $this->marcar('BEN-LIM-11', 1)->assertSessionHasErrors('limite');
        $this->assertDatabaseMissing('entregas_raciones', [
            'beneficiario_id' => Beneficiario::where('codigo_beneficiario', 'BEN-LIM-11')->value('id'),
        ]);
    }
}