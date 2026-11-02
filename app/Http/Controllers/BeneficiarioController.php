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

    public function mostrarAsistencia()
    {
        // Sumar el arroz consumido hoy (raciones * 0.15 kg)
        $consumoHoy = DB::table('entregas_raciones')
            ->where('fecha_entrega', date('Y-m-d'))
            ->sum(DB::raw('raciones_retiradas * 0.15'));
            
        return view('asistencia.index', compact('consumoHoy'));
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

    // Actualizar un beneficiario (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo_beneficiario' => 'required|string|max:20|unique:beneficiarios,codigo_beneficiario,'.$id,
            'tipo_comensal' => 'required|in:Socio/Cocinera,Público General',
            'raciones_asignadas' => 'required|integer|min:1|max:4'
        ]);

        try {
            DB::table('beneficiarios')->where('id', $id)->update([
                'codigo_beneficiario' => $request->codigo_beneficiario,
                'tipo_comensal' => $request->tipo_comensal,
                'raciones_asignadas' => $request->raciones_asignadas,
                'updated_at' => now()
            ]);
            return redirect()->back()->with('success', 'Beneficiario actualizado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    // Dar de baja lógica (DESTROY)
    public function destroy($id)
    {
        try {
            \App\Models\Beneficiario::findOrFail($id)->delete(); // Aplica SoftDeletes
            return redirect()->back()->with('success', 'Beneficiario dado de baja lógicamente.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}