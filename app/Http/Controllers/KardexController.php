<?php

namespace App\Http\Controllers;

use App\Models\EntregaRacion;
use Illuminate\Support\Facades\DB;

/**
 * Control de almacén (Kardex): stock, semáforo y autonomía estimada (Algoritmo 2).
 * Autonomía = stock actual / consumo diario promedio de las últimas 2 semanas.
 */
class KardexController extends Controller
{
    private const KG_POR_RACION = 0.15;
    private const DIAS_VENTANA  = 14;

    public function index()
    {
        $insumos = DB::table('insumos')->get();

        // El consumo diario solo se registra automáticamente para el arroz (0.15 kg por ración entregada)
        $racionesVentana = (int) EntregaRacion::whereBetween('fecha_entrega', [
            today()->subDays(self::DIAS_VENTANA - 1)->toDateString(),
            today()->toDateString(),
        ])->sum('raciones_retiradas');
        $consumoDiarioArroz = round($racionesVentana * self::KG_POR_RACION / self::DIAS_VENTANA, 2);

        foreach ($insumos as $insumo) {
            $insumo->autonomia_dias = ($insumo->nombre_insumo === 'Arroz Común' && $consumoDiarioArroz > 0)
                ? round($insumo->stock_actual / $consumoDiarioArroz, 1)
                : null;
        }

        return view('kardex.index', compact('insumos', 'consumoDiarioArroz'));
    }
}