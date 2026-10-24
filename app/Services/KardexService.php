<?php

namespace App\Services;

use App\Models\MovimientoKardex;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class KardexService
{
    /**
     * Registra una salida de insumos hacia la cocina evaluando las restricciones de la MPA.
     * 
     * @param int $beneficiarioId
     * @param float $cantidadKg
     * @param string|null $detalle
     * @return MovimientoKardex
     * @throws Exception
     */
    public function registrarSalidaCocina(int $beneficiarioId, float $cantidadKg, ?string $detalle = null): MovimientoKardex
    {
        $fechaHoy = Carbon::today()->toDateString();
        
        // Algoritmo de Control: Sumatoria atómica de los kilogramos de arroz despachados hoy
        $totalDespachadoHoy = MovimientoKardex::where('tipo_movimiento', 'Salida - Cocina')
            ->whereDate('created_at', $fechaHoy)
            ->sum('cantidad_kg');
            
        // Regla de Negocio Crítica: Evaluación del umbral rígido municipal de 6.00 kg de arroz
        if (($totalDespachadoHoy + $cantidadKg) > 6.00) {
            $disponible = 6.00 - $totalDespachadoHoy;
            throw new Exception(
                "Operación Bloqueada: El despacho solicitado excede el límite máximo de 6.00 kg de arroz diarios establecido por la Municipalidad Provincial de Arequipa. Saldo disponible para hoy: " . number_format($disponible, 2) . " kg."
            );
        }

        // Persistencia Inmutable en MySQL si cumple la restricción
        return MovimientoKardex::create([
            'beneficiario_id' => $beneficiarioId,
            'usuario_id'      => Auth::id() ?? 1, // ID del operador logueado o cuenta raíz de prueba
            'tipo_movimiento'  => 'Salida - Cocina',
            'cantidad_kg'     => $cantidadKg,
            'motivo_detalle'  => $detalle ?? 'Despacho automatizado para consumo diario de raciones.'
        ]);
    }
}