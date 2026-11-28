<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Matriz de permisos (informe, 3.2): el Voluntario consulta el Kardex por diseño,
 * pero no accede a ningún módulo de gestión.
 */
class AccesoPorRolTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_voluntario_ve_el_kardex_por_diseno_pero_no_los_modulos_de_gestion(): void
    {
        $voluntario = User::factory()->create(['rol' => 'Voluntario']);

        $this->actingAs($voluntario)->get('/kardex')->assertOk();

        foreach (['/reportes', '/beneficiarios', '/insumos', '/gastos', '/lotes', '/menus', '/documentos'] as $ruta) {
            $this->actingAs($voluntario)->get($ruta)->assertForbidden();
        }
    }
}