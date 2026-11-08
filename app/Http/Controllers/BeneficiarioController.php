<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KardexService;
use Illuminate\Support\Facades\DB;
use App\Models\Beneficiario;
use Exception;

class BeneficiarioController extends Controller
{
    protected KardexService $kardexService;

    public function __construct(KardexService $kardexService)
    {
        $this->kardexService = $kardexService;
    }

    // ==========================================
    // MÓDULO: CONTROL DE ASISTENCIA
    // ==========================================
    public function mostrarAsistencia()
    {
        $consumoHoy = DB::table('entregas_raciones')
            ->where('fecha_entrega', date('Y-m-d'))
            ->sum(DB::raw('raciones_retiradas * 0.15'));
        return view('asistencia.index', compact('consumoHoy'));
    }

    public function registrarAsistencia(Request $request)
    {
        $validated = $request->validate([
            'codigo_beneficiario' => 'required|string|max:20',
            'tipo_comensal'       => 'required|in:Socio/Cocinera,Público General',
            'raciones_retiradas'  => 'required|integer|min:1|max:4'
        ]);

        // Eloquent respeta SoftDeletes: un beneficiario dado de baja no puede registrar asistencia
        $beneficiario = Beneficiario::where('codigo_beneficiario', $validated['codigo_beneficiario'])
            ->where('estado', true)
            ->first();

        if (!$beneficiario) {
            return redirect()->back()->withErrors(['error' => 'El código de comensal ingresado no figura como Activo en el padrón.']);
        }

        try {
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

    // ==========================================
    // MÓDULO: CRUD BENEFICIARIOS
    // ==========================================
    public function index()
    {
        // Eloquent excluye automáticamente los registros con deleted_at (baja lógica)
        $beneficiarios = Beneficiario::where('estado', true)
            ->orderBy('codigo_beneficiario')
            ->paginate(50);

        return view('beneficiarios.index', compact('beneficiarios'));
    }

    public function create()
    {
        return view('beneficiarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_beneficiario'  => 'required|string|max:20|unique:beneficiarios,codigo_beneficiario',
            'tipo_comensal'        => 'required|in:Socio/Cocinera,Público General',
            'cantidad_integrantes' => 'required|integer|min:1',
            'raciones_asignadas'   => 'required|integer|min:1|max:4',
        ]);

        Beneficiario::create([
            'codigo_beneficiario'  => $request->codigo_beneficiario,
            'tipo_comensal'        => $request->tipo_comensal,
            'cantidad_integrantes' => $request->cantidad_integrantes,
            'raciones_asignadas'   => $request->raciones_asignadas,
            'fecha_incorporacion'  => now(),
            'estado'               => true,
        ]);

        return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario creado exitosamente.');
    }

    public function edit($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);
        return view('beneficiarios.edit', compact('beneficiario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo_beneficiario' => 'required|string|max:20|unique:beneficiarios,codigo_beneficiario,'.$id,
            'tipo_comensal'       => 'required|in:Socio/Cocinera,Público General',
            'raciones_asignadas'  => 'required|integer|min:1|max:4'
        ]);

        try {
            $beneficiario = Beneficiario::findOrFail($id);
            $beneficiario->update([
                'codigo_beneficiario' => $request->codigo_beneficiario,
                'tipo_comensal'       => $request->tipo_comensal,
                'raciones_asignadas'  => $request->raciones_asignadas,
            ]);
            return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario actualizado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            // Baja lógica: se desactiva el estado y se registra deleted_at (SoftDeletes)
            $beneficiario = Beneficiario::findOrFail($id);
            $beneficiario->update(['estado' => false]);
            $beneficiario->delete(); 

            return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario dado de baja lógicamente.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}