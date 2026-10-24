<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Beneficiario;
use App\Models\MovimientoKardex;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database de forma atómica.
     */
    public function run(): void
    {
        // 1. Crear el usuario administrador de prueba (Encargada Sra. Félipe)
        $user = User::create([
            'name'     => 'Félipe Comedor',
            'email'    => 'felipe.characato@gmail.com',
            'password' => Hash::make('Characato2026*'),
        ]);

        // 2. Inyectar datos semilla anonimizados en el padrón de beneficiarios (Ley N° 29733)
        $comensales = [
            ['codigo' => 'BEN-CHA-001', 'tipo' => 'Socio/Cocinera', 'integrantes' => 4, 'raciones' => 3],
            ['codigo' => 'BEN-CHA-002', 'tipo' => 'Público General', 'integrantes' => 2, 'raciones' => 2],
            ['codigo' => 'BEN-CHA-003', 'tipo' => 'Público General', 'integrantes' => 5, 'raciones' => 4],
            ['codigo' => 'BEN-CHA-004', 'tipo' => 'Socio/Cocinera', 'integrantes' => 3, 'raciones' => 2],
        ];

        foreach ($comensales as $data) {
            $beneficiario = Beneficiario::create([
                'codigo_beneficiario'  => $data['codigo'],
                'tipo_comensal'        => $data['tipo'],
                'cantidad_integrantes' => $data['integrantes'],
                'raciones_asignadas'   => $data['raciones'],
                'fecha_incorporacion'  => Carbon::now()->subMonths(6),
                'estado'               => true
            ]);

            // 3. Simular transacciones históricas en el almacén del Kardex para auditoría de la MPA
            MovimientoKardex::create([
                'beneficiario_id' => $beneficiario->id,
                'usuario_id'      => $user->id,
                'tipo_movimiento'  => 'Entrada - Municipal',
                'cantidad_kg'     => 50.00,
                'motivo_detalle'  => 'Carga inicial de sacos de arroz comunes remitidos por la Municipalidad.'
            ]);
        }
    }
}


