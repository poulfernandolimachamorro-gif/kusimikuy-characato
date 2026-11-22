<?php

namespace Tests\Feature;

use App\Models\Beneficiario;
use App\Models\EntregaRacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Algoritmo 2: autonomía = stock actual / consumo diario promedio de las últimas 2 semanas.
 */
class KardexAutonomiaTest extends TestCase
{
    use RefreshDatabase;

    public function test_calcula_la_autonomia_del_arroz_con_el_consumo_de_14_dias(): void
    {
        $voluntario = User::factory()->create(['rol' => 'Voluntario']);

        DB::table('insumos')->insert([
            'nombre_insumo' => 'Arroz Común', 'stock_actual' => 60.00, 'stock_minimo_alerta' => 10.00,
            'limite_consumo_diario' => 6.00, 'unidad_medida' => 'Kilogramos',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $beneficiario = Beneficiario::create([
            'codigo_beneficiario' => 'BEN-KDX-001', 'tipo_comensal' => 'Público General',
            'cantidad_integrantes' => 3, 'raciones_asignadas' => 4,
            'fecha_incorporacion' => now()->subMonth(), 'estado' => true,
        ]);

        // 4 raciones diarias durante 14 días = 56 raciones = 8.4 kg  ->  0.60 kg por día
        for ($d = 0; $d < 14; $d++) {
            EntregaRacion::create([
                'beneficiario_id' => $beneficiario->id,
                'fecha_entrega' => today()->subDays($d)->toDateString(),
                'raciones_retiradas' => 4, 'cuota_cobrada' => 0,
            ]);
        }

        // 60 kg / 0.60 kg por día = 100 días de autonomía
        $this->actingAs($voluntario)->get('/kardex')
            ->assertOk()
            ->assertViewHas('consumoDiarioArroz', 0.6)
            ->assertViewHas('insumos', fn ($insumos) => (float) $insumos->first()->autonomia_dias === 100.0);
    }
}