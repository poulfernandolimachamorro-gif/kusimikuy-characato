<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\EntregaRacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Control de asistencia diaria (RF-03).
 *
 * Contrasta el padrón activo con las raciones entregadas en una fecha para mostrar
 * quiénes asistieron y quiénes no, y cuánto del cupo diario se utilizó.
 * Es de solo lectura: el marcado de asistencia lo registra BeneficiarioController.
 */
class ControlAsistenciaController extends Controller
{
    /** Tope municipal diario de arroz (kg) y consumo por ración (kg): 6.00 / 0.15 = 40 raciones. */
    private const TOPE_KG = 6.00;
    private const KG_POR_RACION = 0.15;

    public function index(Request $request)
    {
        // No se pueden consultar fechas futuras: todavía no existen entregas.
        $datos = $request->validate([
            'fecha'    => ['nullable', 'date', 'before_or_equal:today'],
            'ausentes' => ['nullable', 'boolean'],
        ]);

        $fecha = isset($datos['fecha'])
            ? Carbon::parse($datos['fecha'])->toDateString()
            : today()->toDateString();
        $soloAusentes = (bool) ($datos['ausentes'] ?? false);

        // Entregas de la fecha, indexadas por beneficiario para cruzarlas sin consultas repetidas
        $entregas = EntregaRacion::whereDate('fecha_entrega', $fecha)->get()->keyBy('beneficiario_id');

        // Padrón activo a esa fecha, marcando si asistió y cuántas raciones retiró
        $padron = Beneficiario::where('estado', true)
            ->whereDate('fecha_incorporacion', '<=', $fecha)
            ->orderBy('codigo_beneficiario')
            ->get()
            ->map(function ($beneficiario) use ($entregas) {
                $entrega = $entregas->get($beneficiario->id);
                $beneficiario->asistio = $entrega !== null;
                $beneficiario->raciones_retiradas = $entrega->raciones_retiradas ?? 0;

                return $beneficiario;
            });

        $totalPadron      = $padron->count();
        $asistieron       = $padron->where('asistio', true)->count();
        $ausentes         = $totalPadron - $asistieron;
        $porcentaje       = $totalPadron > 0 ? (int) round($asistieron / $totalPadron * 100) : 0;
        $racionesServidas = (int) $entregas->sum('raciones_retiradas');
        $cupoRaciones     = (int) round(self::TOPE_KG / self::KG_POR_RACION);

        $listado = $soloAusentes ? $padron->where('asistio', false) : $padron;

        return view('asistencia.control', compact(
            'fecha', 'listado', 'totalPadron', 'asistieron', 'ausentes',
            'porcentaje', 'racionesServidas', 'cupoRaciones', 'soloAusentes'
        ));
    }
}