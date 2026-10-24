<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class KardexService
{
    /**
     * Procesa la transacción atómica de asistencia, caja y descuento de almacén.
     * Satisface plenamente los requerimientos funcionales RF-03 y RF-04 del informe.
     */
    public function registrarEntrega($beneficiario, int $raciones, string $tipoComensal, bool $exonerado): float
    {
        // 1. FISCALIZACIÓN DEL LÍMITE DE ARROZ MUNICIPAL (RF-04)
        $kgPorRacion = 0.15; // 150 gramos establecidos en la receta del informe
        $gastoArrozNuevo = $raciones * $kgPorRacion;
        
        // Sumar consumos procesados con éxito en la fecha actual
        $arrozConsumidoHoy = DB::table('entregas_raciones')
            ->where('fecha_entrega', date('Y-m-d'))
            ->sum(DB::raw('raciones_retiradas * 0.15'));

        if (($arrozConsumidoHoy + $gastoArrozNuevo) > 6.00) {
            throw new Exception("Transacción abortada: La orden excede el límite municipal de 6.00 kg de arroz diarios. Restan únicamente " . number_format(6.00 - $arrozConsumidoHoy, 2) . " kg.");
        }

        // 2. AUTOMATIZACIÓN DE TARIFAS SOCIALES (RF-03)
        $tarifaBase = ($tipoComensal === 'Socio/Cocinera') ? 5.00 : 8.00;
        $cuotaCalculada = $raciones * $tarifaBase;

        if ($exonerado) {
            $cuotaCalculada = 0.00;
        }

        // 3. INYECCIÓN ATÓMICA MEDIANTE TRANSACCIONES SQL (RNF-02)
        DB::beginTransaction();
        try {
            // Guardar el registro diario en la bitácora de entregas
            $entregaId = DB::table('entregas_raciones')->insertGetId([
                'beneficiario_id'    => $beneficiario->id,
                'fecha_entrega'      => date('Y-m-d'),
                'raciones_retiradas' => $raciones,
                'cuota_cobrada'      => $cuotaCalculada,
                'created_at'         => now(),
                'updated_at'         => now()
            ]);

            // Sincronizar el flujo financiero de ingresos en caja chica
            DB::table('ingresos_caja')->insert([
                'tipo_ingreso'  => 'Cuotas Diarias',
                'monto'         => $cuotaCalculada,
                'fecha_ingreso' => date('Y-m-d'),
                'entrega_id'    => $entregaId,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            // Descontar físicamente las existencias del insumo base en el Kardex
            DB::table('insumos')
                ->where('nombre_insumo', 'Arroz Común')
                ->decrement('stock_actual', $gastoArrozNuevo);

            DB::commit();
            return $cuotaCalculada;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Fallo crítico en el resguardo relacional de datos: " . $e->getMessage());
        }
    }
}