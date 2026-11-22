<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * RF-06: el informe PDF se genera para el mes elegido y rechaza meses inválidos.
 */
class ReporteMensualTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_encargada_descarga_el_pdf_del_mes_y_se_rechaza_un_mes_invalido(): void
    {
        $encargada = User::factory()->create(['rol' => 'Encargada']);

        $respuesta = $this->actingAs($encargada)->get('/reportes/pdf?mes=' . now()->format('Y-m'));
        $respuesta->assertOk();
        $this->assertStringContainsString('application/pdf', $respuesta->headers->get('content-type'));

        $this->actingAs($encargada)->get('/reportes/pdf?mes=2026-13')->assertSessionHasErrors('mes');
    }
}