<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class KardexService
{
    /**
     * Procesa la asistencia diaria y el cobro (RF-03), con validación atómica (RF-04).
     */
    public function registrarEntrega($beneficiario, int $raciones, string $tipoComensal, bool $exonerado): float
    {
        $kgPorRacion = 0.15;
        $gastoArrozNuevo = $raciones * $kgPorRacion;

        return DB::transaction(function () use ($beneficiario, $raciones, $tipoComensal, $exonerado, $gastoArrozNuevo) {
            
            // 1. Bloqueo pesimista del insumo para evitar condiciones de carrera
            $insumo = DB::table('insumos')
                ->where('nombre_insumo', 'Arroz Común')
                ->lockForUpdate()
                ->first();

            if (!$insumo) {
                throw new Exception("Error crítico: El insumo 'Arroz Común' no está registrado en el almacén.");
            }

            // 2. Fiscalización del tope diario (RF-04)
            $arrozConsumidoHoy = DB::table('entregas_raciones')
                ->where('fecha_entrega', date('Y-m-d'))
                ->sum(DB::raw('raciones_retiradas * 0.15'));

            if (($arrozConsumidoHoy + $gastoArrozNuevo) > 6.00) {
                throw new Exception("Transacción abortada: La orden excede el límite municipal de 6.00 kg de arroz diarios. Restan únicamente " . number_format(6.00 - $arrozConsumidoHoy, 2) . " kg.");
            }

            if ($insumo->stock_actual < $gastoArrozNuevo) {
                throw new Exception("Quiebre de Almacén: No hay stock físico suficiente de arroz para cubrir esta entrega.");
            }

            // 3. Liquidación de cuotas (RF-03)
            $tarifaBase = ($tipoComensal === 'Socio/Cocinera') ? 5.00 : 8.00;
            $cuotaCalculada = $exonerado ? 0.00 : ($raciones * $tarifaBase);

            // 4. Persistencia
            $entregaId = DB::table('entregas_raciones')->insertGetId([
                'beneficiario_id'    => $beneficiario->id,
                'fecha_entrega'      => date('Y-m-d'),
                'raciones_retiradas' => $raciones,
                'cuota_cobrada'      => $cuotaCalculada,
                'created_at'         => now(),
                'updated_at'         => now()
            ]);

            DB::table('ingresos_caja')->insert([
                'tipo_ingreso'  => 'Cuotas Diarias',
                'monto'         => $cuotaCalculada,
                'fecha_ingreso' => date('Y-m-d'),
                'entrega_id'    => $entregaId,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            // 5. Descuento físico del stock
            DB::table('insumos')
                ->where('id', $insumo->id)
                ->decrement('stock_actual', $gastoArrozNuevo);

            return $cuotaCalculada;
        });
    }

    /**
     * Endpoint de salida directa desde cocina (RF-04) requerido por la API.
     */
    public function registrarSalidaCocina(int $beneficiarioId, float $cantidadKg, ?string $motivoDetalle)
    {
        return DB::transaction(function () use ($beneficiarioId, $cantidadKg, $motivoDetalle) {
            
            $insumo = DB::table('insumos')
                ->where('nombre_insumo', 'Arroz Común')
                ->lockForUpdate()
                ->first();

            if (!$insumo) {
                throw new Exception("El insumo 'Arroz Común' no existe en el almacén.");
            }

            $consumoEntregas = DB::table('entregas_raciones')
                ->where('fecha_entrega', date('Y-m-d'))
                ->sum(DB::raw('raciones_retiradas * 0.15'));

            $consumoDirecto = DB::table('movimientos_kardex')
                ->whereDate('created_at', date('Y-m-d'))
                ->where('tipo_movimiento', 'Salida - Cocina')
                ->sum('cantidad_kg');

            $totalHoy = $consumoEntregas + $consumoDirecto;

            if (($totalHoy + $cantidadKg) > 6.00) {
                $restante = 6.00 - $totalHoy;
                throw new Exception("Límite Municipal Excedido: El cupo remanente de arroz para hoy es de " . number_format($restante, 2) . " kg.");
            }

            if ($insumo->stock_actual < $cantidadKg) {
                throw new Exception("Quiebre de Almacén: Stock insuficiente.");
            }

            DB::table('insumos')
                ->where('id', $insumo->id)
                ->decrement('stock_actual', $cantidadKg);

            $id = DB::table('movimientos_kardex')->insertGetId([
                'beneficiario_id' => $beneficiarioId,
                'usuario_id'      => auth()->id() ?? 1,
                'tipo_movimiento' => 'Salida - Cocina',
                'cantidad_kg'     => $cantidadKg,
                'motivo_detalle'  => $motivoDetalle ?? 'Despacho diario regular.',
                'created_at'      => now()
            ]);

            return DB::table('movimientos_kardex')->where('id', $id)->first();
        });
    }
}