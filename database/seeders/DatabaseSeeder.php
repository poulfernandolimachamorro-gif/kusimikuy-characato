<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Beneficiario;
use App\Models\MovimientoKardex;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el usuario administrador (A prueba de duplicados)
        $user = User::firstOrCreate(
            ['email' => 'felipe.characato@gmail.com'],
            [
                'name'     => 'Félipe Comedor',
                'password' => Hash::make('Characato2026*'),
            ]
        );

        // 2. Inyectar datos semilla en el padrón (A prueba de duplicados)
        $comensales = [
            ['codigo' => 'BEN-CHA-001', 'tipo' => 'Socio/Cocinera', 'integrantes' => 4, 'raciones' => 3],
            ['codigo' => 'BEN-CHA-002', 'tipo' => 'Público General', 'integrantes' => 2, 'raciones' => 2],
            ['codigo' => 'BEN-CHA-003', 'tipo' => 'Público General', 'integrantes' => 5, 'raciones' => 4],
            ['codigo' => 'BEN-CHA-004', 'tipo' => 'Socio/Cocinera', 'integrantes' => 3, 'raciones' => 2],
        ];

        foreach ($comensales as $data) {
            // Usamos firstOrCreate para que no falle si ya existe
            $beneficiario = Beneficiario::firstOrCreate(
                ['codigo_beneficiario' => $data['codigo']],
                [
                    'tipo_comensal'        => $data['tipo'],
                    'cantidad_integrantes' => $data['integrantes'],
                    'raciones_asignadas'   => $data['raciones'],
                    'fecha_incorporacion'  => Carbon::now()->subMonths(6),
                    'estado'               => true
                ]
            );

            // 3. Simular transacciones históricas (Solo si el beneficiario se acaba de crear)
            if ($beneficiario->wasRecentlyCreated) {
                MovimientoKardex::create([
                    'beneficiario_id' => $beneficiario->id,
                    'usuario_id'      => $user->id,
                    'tipo_movimiento' => 'Entrada - Municipal',
                    'cantidad_kg'     => 50.00,
                    'motivo_detalle'  => 'Carga inicial de sacos de arroz comunes remitidos por la Municipalidad.'
                ]);
            }
        }

        // 4. Insumo inicial para el Kardex (A prueba de duplicados)
        DB::table('insumos')->updateOrInsert(
            ['nombre_insumo' => 'Arroz Común'], // Busca si ya existe este insumo
            [
                'stock_actual' => 50.00,
                'stock_minimo_alerta' => 10.00,
                'limite_consumo_diario' => 6.00,
                'unidad_medida' => 'Kilogramos',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}