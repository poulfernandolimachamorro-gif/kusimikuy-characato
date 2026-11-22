<?php

namespace Database\Seeders;

use App\Models\Beneficiario;
use App\Models\DocumentoLegal;
use App\Models\EntregaRacion;
use App\Models\LoteInventario;
use App\Models\MenuReceta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Datos de demostración para la exposición (todos ficticios, ver nota del Anexo G).
 *
 * Es idempotente: cada registro se identifica por una clave natural y se escribe con
 * firstOrCreate / updateOrCreate / updateOrInsert, de modo que puede ejecutarse varias
 * veces (por ejemplo, en cada arranque en la nube) sin duplicar filas el mismo día.
 * Debe ejecutarse después de DatabaseSeeder, que crea los usuarios demo.
 */
class DemoDataSeeder extends Seeder
{
    private const TOTAL_PADRON    = 80;
    private const DIAS_HISTORIAL  = 10;
    private const TOPE_RACIONES   = 40;   // 6.00 kg de arroz / 0.15 kg por ración
    private const RACIONES_HOY    = 34;   // deja ~6 raciones de cupo para mostrar el bloqueo en vivo
    private const CUOTA_SOCIO     = 5.00;
    private const CUOTA_PUBLICO   = 8.00;

    /** Comensales que no asistieron en el historial: aparecerán primero entre los suplentes. */
    private const SIN_ASISTENCIA = ['BEN-CHA-077', 'BEN-CHA-078', 'BEN-CHA-079', 'BEN-CHA-080'];

    public function run(): void
    {
        $encargada = User::where('email', 'felipe.characato@gmail.com')->firstOrFail();

        DB::transaction(function () use ($encargada) {
            $this->sembrarPadron();
            $insumos = $this->sembrarInsumos();
            $this->sembrarLotes($insumos);
            $this->sembrarMenus($insumos);
            $this->sembrarDocumentos();
            $this->sembrarGastos($encargada->id);
            $this->sembrarAsistencias();
            $this->sembrarOtrosIngresos();
            $this->sembrarMerma($encargada->id);
        });
    }

    /** Completa el padrón hasta las 80 familias que declara el informe (BEN-CHA-012 a 080). */
    private function sembrarPadron(): void
    {
        for ($i = 12; $i <= self::TOTAL_PADRON; $i++) {
            // withTrashed: si una fila fue dada de baja lógica, no se intenta insertar de nuevo el código
            Beneficiario::withTrashed()->firstOrCreate(
                ['codigo_beneficiario' => sprintf('BEN-CHA-%03d', $i)],
                [
                    'tipo_comensal'        => $i % 4 === 0 ? 'Socio/Cocinera' : 'Público General',
                    'cantidad_integrantes' => 2 + ($i % 4),
                    'raciones_asignadas'   => $i % 3 === 0 ? 2 : 1,
                    'fecha_incorporacion'  => Carbon::now()->subMonths(6),
                    'estado'               => true,
                ]
            );
        }
    }

    /** Insumos con los tres estados del semáforo: suficiente, stock bajo y agotado. */
    private function sembrarInsumos(): array
    {
        // [nombre, stock, mínimo de alerta, límite diario (kg), unidad]
        $catalogo = [
            ['Arroz Común',     120.00, 20.00, 6.00, 'Kilogramos'],
            ['Aceite de Soya',    4.00,  5.00, null, 'Litros'],            // Stock bajo
            ['Atún en conserva',  0.00, 10.00, null, 'Unidades'],          // Agotado (omitido por la MPA)
            ['Papa',             45.00, 15.00, null, 'Kilogramos'],
            ['Lenteja',          18.00,  8.00, null, 'Kilogramos'],
        ];

        foreach ($catalogo as [$nombre, $stock, $minimo, $limite, $unidad]) {
            DB::table('insumos')->updateOrInsert(
                ['nombre_insumo' => $nombre],
                [
                    'stock_actual'          => $stock,
                    'stock_minimo_alerta'   => $minimo,
                    'limite_consumo_diario' => $limite,
                    'unidad_medida'         => $unidad,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]
            );
        }

        return DB::table('insumos')->pluck('id', 'nombre_insumo')->all();
    }

    /** Un lote defectuoso ("arroz verde") y uno que vence en pocos días, para las alertas del panel. */
    private function sembrarLotes(array $insumos): void
    {
        // [código, insumo, días hasta el vencimiento, estado de calidad]
        $lotes = [
            ['L-ARR-01', 'Arroz Común',    150, 'Óptimo'],
            ['L-ARR-02', 'Arroz Común',     14, 'Defectuoso/Verde'],
            ['L-ACE-01', 'Aceite de Soya',   4, 'Óptimo'],
            ['L-LEN-01', 'Lenteja',        240, 'Óptimo'],
        ];

        foreach ($lotes as [$codigo, $insumo, $dias, $estado]) {
            LoteInventario::updateOrCreate(
                ['codigo_lote' => $codigo],
                [
                    'insumo_id'         => $insumos[$insumo],
                    'fecha_vencimiento' => Carbon::today()->addDays($dias)->toDateString(),
                    'estado_calidad'    => $estado,
                ]
            );
        }
    }

    private function sembrarMenus(array $insumos): void
    {
        // [plato, insumo, gramos por ración]
        $menus = [
            ['Arroz graneado',   'Arroz Común', 150],
            ['Lenteja al chaki', 'Lenteja',     150],
            ['Guiso de papa',    'Papa',        200],
        ];

        foreach ($menus as [$plato, $insumo, $gramos]) {
            MenuReceta::updateOrCreate(
                ['nombre_plato' => $plato, 'insumo_id' => $insumos[$insumo]],
                ['gramos_por_racion' => $gramos]
            );
        }
    }

    /** La Resolución Municipal queda "Por vencer" (vence en 37 días) para mostrar la alerta de RF-05. */
    private function sembrarDocumentos(): void
    {
        $documentos = [
            ['Resolución Municipal',   Carbon::today()->subYears(2)->addDays(37), Carbon::today()->addDays(37)],
            ['Registros Públicos',     Carbon::today()->subMonths(8),             Carbon::today()->addMonths(16)],
            ['Libro de Actas Mensual', Carbon::today()->startOfMonth(),           Carbon::today()->addYear()],
        ];

        foreach ($documentos as [$tipo, $emision, $caducidad]) {
            DocumentoLegal::updateOrCreate(
                ['tipo_documento' => $tipo],
                [
                    'fecha_emision'   => $emision->toDateString(),
                    'fecha_caducidad' => $caducidad->toDateString(),
                ]
            );
        }
    }

    private function sembrarGastos(int $usuarioId): void
    {
        // Una compra de mercado por cada día del historial
        for ($d = 1; $d <= self::DIAS_HISTORIAL; $d++) {
            $fecha = Carbon::today()->subDays($d);
            $this->gasto(
                'Compra de mercado del ' . $fecha->format('d/m'),
                140 + (($d * 11) % 60),
                'Boleta',
                sprintf('B001-%05d', 100 + $d),
                $fecha,
                $usuarioId
            );
        }

        $this->gasto('Recarga de balón de gas', 48.00, 'Recibo Interno', null, Carbon::today()->subDays(6), $usuarioId);
        $this->gasto('Compra de aceite y condimentos', 29.90, 'Factura', 'F001-00045', Carbon::today()->subDays(3), $usuarioId);
    }

    private function gasto(string $concepto, float $monto, string $tipo, ?string $numero, Carbon $fecha, int $usuarioId): void
    {
        DB::table('gastos')->updateOrInsert(
            ['concepto' => $concepto],
            [
                'monto'              => $monto,
                'tipo_comprobante'   => $tipo,
                'numero_comprobante' => $numero,
                'fecha_gasto'        => $fecha->toDateString(),
                'usuario_id'         => $usuarioId,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]
        );
    }

    /**
     * Asistencias de los últimos días y de hoy, con su cuota en caja. Cada comensal tiene una
     * frecuencia distinta (1 a 3 de cada 5 días) y nunca se supera el tope diario de 40 raciones.
     */
    private function sembrarAsistencias(): void
    {
        $padron = Beneficiario::where('estado', true)->orderBy('codigo_beneficiario')->get()->all();
        $total  = count($padron);

        for ($dia = 0; $dia <= self::DIAS_HISTORIAL; $dia++) {
            $fecha    = Carbon::today()->subDays($dia)->toDateString();
            $cupo     = $dia === 0 ? self::RACIONES_HOY : self::TOPE_RACIONES;
            $servidas = 0;

            // Se rota el punto de partida cada día para que el tope no favorezca siempre a los mismos
            $desde = ($dia * 13) % $total;
            $orden = array_merge(array_slice($padron, $desde), array_slice($padron, 0, $desde));

            foreach ($orden as $beneficiario) {
                if (in_array($beneficiario->codigo_beneficiario, self::SIN_ASISTENCIA, true)) {
                    continue;
                }

                $n = $beneficiario->id;
                if ((2 * $n + 3 * $dia) % 5 >= 1 + ($n % 3)) {
                    continue;
                }

                $raciones = (int) $beneficiario->raciones_asignadas;
                if ($servidas + $raciones > $cupo) {
                    continue;
                }

                $tarifa = $beneficiario->tipo_comensal === 'Socio/Cocinera' ? self::CUOTA_SOCIO : self::CUOTA_PUBLICO;
                $cuota  = ($n % 17 === 0) ? 0.00 : $raciones * $tarifa;   // algunos casos exonerados

                $entrega = EntregaRacion::firstOrCreate(
                    ['beneficiario_id' => $beneficiario->id, 'fecha_entrega' => $fecha],
                    ['raciones_retiradas' => $raciones, 'cuota_cobrada' => $cuota]
                );

                // El ingreso en caja solo se crea junto con la entrega (así no se duplica al repetir el seeder)
                if ($entrega->wasRecentlyCreated) {
                    DB::table('ingresos_caja')->insert([
                        'tipo_ingreso'  => 'Cuotas Diarias',
                        'monto'         => $cuota,
                        'fecha_ingreso' => $fecha,
                        'entrega_id'    => $entrega->id,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                }

                $servidas += $raciones;
            }
        }
    }

    /** Subsidio municipal de S/ 400 y una donación vecinal (casos descritos en las entrevistas). */
    private function sembrarOtrosIngresos(): void
    {
        DB::table('ingresos_caja')->updateOrInsert(
            ['tipo_ingreso' => 'Subsidio Municipal'],
            [
                'monto'         => 400.00,
                'fecha_ingreso' => Carbon::today()->subDays(self::DIAS_HISTORIAL)->toDateString(),
                'entrega_id'    => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );

        DB::table('ingresos_caja')->updateOrInsert(
            ['tipo_ingreso' => 'Donación Efectivo'],
            [
                'monto'         => 20.00,
                'fecha_ingreso' => Carbon::today()->subDays(4)->toDateString(),
                'entrega_id'    => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }

    /** Merma registrada por el arroz verde quemado (lote L-ARR-02). */
    private function sembrarMerma(int $usuarioId): void
    {
        DB::table('movimientos_kardex')->updateOrInsert(
            [
                'tipo_movimiento' => 'Salida - Merma',
                'motivo_detalle'  => 'Arroz verde quemado por falta de graneado (lote L-ARR-02)',
            ],
            [
                'beneficiario_id' => null,
                'usuario_id'      => $usuarioId,
                'cantidad_kg'     => 2.50,
                'created_at'      => Carbon::today()->subDays(2),
            ]
        );
    }
}