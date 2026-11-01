<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KardexService;
use Illuminate\Support\Facades\DB;
use Exception;

class BeneficiarioController extends Controller
{
    protected KardexService $kardexService;

    // Inyección de dependencias para desacoplar la arquitectura en capas
    public function __construct(KardexService $kardexService)
    {
        $this->kardexService = $kardexService;
    }

    public function store(Request $request)
    {
        // Validación rápida en línea para asegurar la continuidad operativa
        $validated = $request->validate([
            'codigo_beneficiario' => 'required|string|max:20',
            'tipo_comensal'        => 'required|in:Socio/Cocinera,Público General',
            'raciones_retiradas'   => 'required|integer|min:1|max:4'
        ]);

        // Localizar beneficiario activo anonimizado (Ley N° 29733)
        $beneficiario = DB::table('beneficiarios')
            ->where('codigo_beneficiario', $validated['codigo_beneficiario'])
            ->where('estado', true)
            ->first();

        if (!$beneficiario) {
            return redirect()->back()->withErrors(['error' => 'El código de comensal ingresado no figura como Activo en el padrón.']);
        }

        try {
            // Delegar el cómputo de porciones y flujos de caja al Service Layer
            $cuotaCobrada = $this->kardexService->registrarEntrega(
                $beneficiario,
                $validated['raciones_retiradas'],
                $validated['tipo_comensal'],
                $request->has('exonerado')
            );

            // CAMBIO AQUÍ: Redirige a la misma página (atrás) en lugar del dashboard
            return redirect()->back()->with('success', 'Asistencia registrada con éxito. S/. ' . number_format($cuotaCobrada, 2) . ' integrados a Caja Chica.');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['limite' => $e->getMessage()]);
        }
    }

    // Función para listar a los beneficiarios (READ)
    public function index()
    {
        // Usamos paginación para que no colapse si hay muchos
        $beneficiarios = DB::table('beneficiarios')->where('estado', true)->paginate(10);
        return view('beneficiarios.index', compact('beneficiarios'));
    }
}