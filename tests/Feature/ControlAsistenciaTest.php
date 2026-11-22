<?php

namespace Tests\Feature;

use App\Models\Beneficiario;
use App\Models\EntregaRacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pruebas del control de asistencia diaria: acceso por rol, resumen, cupo y suplentes.
 */
class ControlAsistenciaTest extends TestCase
{
    use RefreshDatabase;

    private function crearBeneficiario(string $codigo, int $raciones = 2): Beneficiario
    {
        return Beneficiario::create([
            'codigo_beneficiario'  => $codigo,
            'tipo_comensal'        => 'Público General',
            'cantidad_integrantes' => 3,
            'raciones_asignadas'   => $raciones,
            'fecha_incorporacion'  => now()->subMonth(),
            'estado'               => true,
        ]);
    }

    private function registrarEntrega(Beneficiario $beneficiario, int $raciones, int $diasAtras = 0): void
    {
        EntregaRacion::create([
            'beneficiario_id'    => $beneficiario->id,
            'fecha_entrega'      => today()->subDays($diasAtras)->toDateString(),
            'raciones_retiradas' => $raciones,
            'cuota_cobrada'      => 0,
        ]);
    }

    public function test_la_voluntaria_ve_el_control_pero_no_el_padron(): void
    {
        $voluntario = User::factory()->create(['rol' => 'Voluntario']);

        $this->actingAs($voluntario)->get('/asistencia/control')->assertOk();
        $this->actingAs($voluntario)->get('/beneficiarios')->assertForbidden();
    }

    public function test_el_resumen_distingue_quien_asistio_y_quien_no(): void
    {
        $encargada = User::factory()->create(['rol' => 'Encargada']);
        $asistio   = $this->crearBeneficiario('BEN-CTL-001', 2);
        $this->crearBeneficiario('BEN-CTL-002', 2);
        $this->registrarEntrega($asistio, 2);

        $this->actingAs($encargada)->get('/asistencia/control')
            ->assertOk()
            ->assertViewHas('totalPadron', 2)
            ->assertViewHas('asistieron', 1)
            ->assertViewHas('ausentes', 1)
            ->assertViewHas('racionesServidas', 2)
            ->assertViewHas('cupoDisponible', 38);
    }

    public function test_los_suplentes_se_ordenan_por_menos_asistencias_en_30_dias(): void
    {
        $encargada = User::factory()->create(['rol' => 'Encargada']);
        $a = $this->crearBeneficiario('BEN-TST-A');
        $b = $this->crearBeneficiario('BEN-TST-B');
        $c = $this->crearBeneficiario('BEN-TST-C');

        // Ninguno asistió hoy; B asistió 2 veces y C una vez en los últimos días, A ninguna
        $this->registrarEntrega($b, 1, 2);
        $this->registrarEntrega($b, 1, 5);
        $this->registrarEntrega($c, 1, 3);

        $this->actingAs($encargada)->get('/asistencia/control')
            ->assertOk()
            ->assertViewHas('suplentes', function ($suplentes) {
                return $suplentes->pluck('codigo_beneficiario')->all() === ['BEN-TST-A', 'BEN-TST-C', 'BEN-TST-B'];
            });
    }

    public function test_sin_cupo_disponible_no_se_sugieren_suplentes(): void
    {
        $encargada = User::factory()->create(['rol' => 'Encargada']);

        // 10 comensales con 4 raciones cada uno completan las 40 raciones del día
        for ($i = 1; $i <= 10; $i++) {
            $this->registrarEntrega($this->crearBeneficiario(sprintf('BEN-FUL-%02d', $i), 4), 4);
        }
        $this->crearBeneficiario('BEN-FUL-AUS', 1);

        $this->actingAs($encargada)->get('/asistencia/control')
            ->assertOk()
            ->assertViewHas('cupoDisponible', 0)
            ->assertViewHas('suplentes', fn ($suplentes) => $suplentes->isEmpty());
    }

    public function test_no_se_puede_consultar_una_fecha_futura(): void
    {
        $encargada = User::factory()->create(['rol' => 'Encargada']);

        $this->actingAs($encargada)
            ->get('/asistencia/control?fecha=' . today()->addDay()->toDateString())
            ->assertSessionHasErrors('fecha');
    }
}