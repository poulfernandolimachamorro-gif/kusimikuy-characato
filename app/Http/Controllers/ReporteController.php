<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function descargarPDF()
    {
        $ingresos = DB::table('ingresos_caja')->orderBy('fecha_ingreso', 'desc')->get();
        $gastos = DB::table('gastos')->orderBy('fecha_gasto', 'desc')->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalGastos = $gastos->sum('monto');
        $balance = $totalIngresos - $totalGastos;

        $pdf = Pdf::loadView('reportes.pdf', compact('ingresos', 'gastos', 'totalIngresos', 'totalGastos', 'balance'));
        return $pdf->download('Reporte_MPA_' . date('Y-m-d') . '.pdf');
    }
}