<?php

namespace Tests\Feature;

use App\Models\Beneficiario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Pruebas de los Form Requests (validación en español) y de la protección del Arroz Común.
 */
class ValidacionFormulariosTest extends TestCase
{
    use RefreshDatabase;

    private User $encargada;

    protected function setUp(): void
    {
        parent::setUp();
        $this->encargada = User::factory()->create(['rol' => 'Encargada']);
    }

    private function crearInsumo(string $nombre): int
    {
        return DB::table('insumos')->insertGetId([
            'nombre_insumo'       => $nombre,
            'stock_actual'        => 50.00,
            'stock_minimo_alerta' => 10.00,
            'unidad_medida'       => 'Kilogramos',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
    }

    public function test_el_padron_rechaza_un_codigo_duplicado_con_mensaje_en_espanol(): void
    {
        Beneficiario::create([
            'codigo_beneficiario'  => 'BEN-CHA-050',
            'tipo_comensal'        => 'Público General',
            'cantidad_integrantes' => 2,
            'raciones_asignadas'   => 1,
            'fecha_incorporacion'  => now(),
            'estado'               => true,
        ]);

        // En minúsculas: el request lo normaliza a mayúsculas y detecta el duplicado
        $this->actingAs($this->encargada)->post('/beneficiarios', [
            'codigo_beneficiario'  => 'ben-cha-050',
            'tipo_comensal'        => 'Público General',
            'cantidad_integrantes' => 3,
            'raciones_asignadas'   => 2,
        ])->assertSessionHasErrors(['codigo_beneficiario' => 'Ese código ya está registrado en el padrón.']);
    }

    public function test_el_padron_guarda_el_codigo_normalizado_en_mayusculas(): void
    {
        $this->actingAs($this->encargada)->post('/beneficiarios', [
            'codigo_beneficiario'  => ' ben-cha-051 ',
            'tipo_comensal'        => 'Socio/Cocinera',
            'cantidad_integrantes' => 3,
            'raciones_asignadas'   => 2,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('beneficiarios', ['codigo_beneficiario' => 'BEN-CHA-051']);
    }

    public function test_el_arroz_comun_no_se_puede_eliminar(): void
    {
        $id = $this->crearInsumo('Arroz Común');

        $this->actingAs($this->encargada)->delete("/insumos/{$id}")->assertSessionHasErrors('protegido');

        $this->assertDatabaseHas('insumos', ['id' => $id, 'nombre_insumo' => 'Arroz Común']);
    }

    public function test_el_arroz_comun_no_se_puede_renombrar_pero_si_actualizar_su_stock(): void
    {
        $id = $this->crearInsumo('Arroz Común');

        $this->actingAs($this->encargada)->put("/insumos/{$id}", [
            'nombre_insumo' => 'Arroz Blanco',
            'stock_actual'  => 50,
            'unidad_medida' => 'Kilogramos',
        ])->assertSessionHasErrors('protegido');
        $this->assertDatabaseHas('insumos', ['id' => $id, 'nombre_insumo' => 'Arroz Común']);

        $this->actingAs($this->encargada)->put("/insumos/{$id}", [
            'nombre_insumo' => 'Arroz Común',
            'stock_actual'  => 75,
            'unidad_medida' => 'Kilogramos',
        ])->assertSessionHasNoErrors();
        $this->assertEquals(75.0, (float) DB::table('insumos')->where('id', $id)->value('stock_actual'));
    }

    public function test_el_lote_exige_un_insumo_existente_y_normaliza_el_codigo(): void
    {
        $insumoId = $this->crearInsumo('Lenteja');

        $this->actingAs($this->encargada)->post('/lotes', [
            'insumo_id'      => 9999,
            'codigo_lote'    => 'L-X-01',
            'estado_calidad' => 'Óptimo',
        ])->assertSessionHasErrors('insumo_id');

        $this->actingAs($this->encargada)->post('/lotes', [
            'insumo_id'      => $insumoId,
            'codigo_lote'    => 'l-len-01',
            'estado_calidad' => 'Defectuoso/Verde',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('lotes_inventario', ['codigo_lote' => 'L-LEN-01', 'estado_calidad' => 'Defectuoso/Verde']);
    }
}