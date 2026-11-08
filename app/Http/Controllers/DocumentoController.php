<?php

namespace App\Http\Controllers;

use App\Models\DocumentoLegal;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Control de vigencia de documentos legales (RF-05).
 */
class DocumentoController extends Controller
{
    /** Días de anticipación para marcar un documento como "Por vencer". */
    private const DIAS_ALERTA = 60;

    public function index()
    {
        $hoy = Carbon::today();

        // Estado de vigencia calculado a partir de la fecha de caducidad
        $documentos = DocumentoLegal::orderBy('fecha_caducidad')->get()->map(function ($doc) use ($hoy) {
            $dias = (int) $hoy->diffInDays(Carbon::parse($doc->fecha_caducidad)->startOfDay(), false);

            $doc->dias_restantes  = $dias;
            $doc->estado_vigencia = $dias < 0 ? 'Vencido' : ($dias <= self::DIAS_ALERTA ? 'Por vencer' : 'Vigente');
            $doc->color_vigencia  = ['Vencido' => '#ef4444', 'Por vencer' => '#facc15', 'Vigente' => '#22c55e'][$doc->estado_vigencia];

            return $doc;
        });

        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        return view('documentos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'tipo_documento'  => 'required|in:Resolución Municipal,Registros Públicos,Libro de Actas Mensual',
            'fecha_emision'   => 'required|date',
            'fecha_caducidad' => 'required|date|after:fecha_emision',
        ]);

        DocumentoLegal::create($datos);

        return redirect()->route('documentos.index')->with('success', 'Documento registrado.');
    }

    public function destroy($id)
    {
        DocumentoLegal::findOrFail($id)->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado.');
    }
}
