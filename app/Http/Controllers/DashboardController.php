<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\EntregaRacion;
use Illuminate\Support\Facades\DB;

/**
 * Panel principal: calcula las métricas operativas desde la base de datos
 * y delega la presentación a la vista (controlador delgado, vista sin consultas).
 */
class DashboardController extends Controller
{
    /** Días de anticipación para alertar el vencimiento de lotes. */
    private const DIAS_ALERTA_LOTES = 7;

    /** Días de anticipación para alertar el vencimiento de documentos legales. */
    private const DIAS_ALERTA_DOCUMENTOS = 60;

    public function index()
    {
        $padron      = Beneficiario::where('estado', true)->count();
        $racionesHoy = (int) EntregaRacion::whereDate('fecha_entrega', today())->sum('raciones_retiradas');
        $tiposInsumo = DB::table('insumos')->count();
        $caja        = (float) DB::table('ingresos_caja')->sum('monto') - (float) DB::table('gastos')->sum('monto');

        // UC-02: lotes defectuosos/mermados o que vencen en 7 días o menos (incluye los ya vencidos)
        $lotesAlerta = DB::table('lotes_inventario')
            ->join('insumos', 'insumos.id', '=', 'lotes_inventario.insumo_id')
            ->where(function ($q) {
                $q->where('lotes_inventario.estado_calidad', '!=', 'Óptimo')
                  ->orWhere('lotes_inventario.fecha_vencimiento', '<=', now()->addDays(self::DIAS_ALERTA_LOTES)->toDateString());
            })
            ->select(
                'lotes_inventario.codigo_lote',
                'lotes_inventario.estado_calidad',
                'lotes_inventario.fecha_vencimiento',
                'insumos.nombre_insumo'
            )
            ->get();

        // RF-05: documentos legales vencidos o que vencen en 60 días o menos
        $documentosAlerta = DB::table('documentos_legales')
            ->where('fecha_caducidad', '<=', now()->addDays(self::DIAS_ALERTA_DOCUMENTOS)->toDateString())
            ->count();

        return view('dashboard', compact(
            'padron', 'racionesHoy', 'tiposInsumo', 'caja', 'lotesAlerta', 'documentosAlerta'
        ));
    }
}
