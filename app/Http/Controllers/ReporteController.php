<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Informe mensual de rendición de cuentas (RF-06): caja (ingresos y gastos) y consumo del Kardex.
 */
class ReporteController extends Controller
{
    private const KG_POR_RACION = 0.15;

    public function descargarPDF(Request $request)
    {
        $datos = $request->validate(['mes' => ['nullable', 'date_format:Y-m']]);

        $inicio = Carbon::parse(($datos['mes'] ?? now()->format('Y-m')) . '-01')->startOfDay();
        $desde  = $inicio->toDateString();
        $hasta  = $inicio->copy()->endOfMonth()->toDateString();

        // Ingresos agrupados por tipo y día (un renglón por jornada, no uno por comensal)
        $ingresos = DB::table('ingresos_caja')
            ->whereBetween('fecha_ingreso', [$desde, $hasta])
            ->selectRaw('tipo_ingreso, fecha_ingreso, COUNT(*) as operaciones, SUM(monto) as monto')
            ->groupBy('tipo_ingreso', 'fecha_ingreso')
            ->orderBy('fecha_ingreso')
            ->get();

        $gastos = DB::table('gastos')
            ->whereBetween('fecha_gasto', [$desde, $hasta])
            ->orderBy('fecha_gasto')
            ->get();

        $totalIngresos = (float) $ingresos->sum('monto');
        $totalGastos   = (float) $gastos->sum('monto');
        $balance       = $totalIngresos - $totalGastos;

        // Kardex: consumo diario de arroz derivado de las raciones entregadas (0.15 kg por ración)
        $consumoDiario = DB::table('entregas_raciones')
            ->whereBetween('fecha_entrega', [$desde, $hasta])
            ->selectRaw('fecha_entrega, SUM(raciones_retiradas) as raciones')
            ->groupBy('fecha_entrega')
            ->orderBy('fecha_entrega')
            ->get()
            ->map(fn ($fila) => (object) [
                'fecha'    => $fila->fecha_entrega,
                'raciones' => (int) $fila->raciones,
                'kg'       => round($fila->raciones * self::KG_POR_RACION, 2),
            ]);
        $totalKg = round($consumoDiario->sum('kg'), 2);

        // Mermas registradas en el Kardex durante el mes
        $mermas = DB::table('movimientos_kardex')
            ->where('tipo_movimiento', 'Salida - Merma Insumo Verde')
            ->whereDate('created_at', '>=', $desde)
            ->whereDate('created_at', '<=', $hasta)
            ->orderBy('created_at')
            ->get();

        $mesTexto = ucfirst($inicio->locale('es')->translatedFormat('F Y'));

        $pdf = Pdf::loadView('reportes.pdf', compact(
            'mesTexto', 'ingresos', 'gastos', 'totalIngresos', 'totalGastos', 'balance',
            'consumoDiario', 'totalKg', 'mermas'
        ));

        return $pdf->download('Reporte_MPA_' . $inicio->format('Y-m') . '.pdf');
    }
}