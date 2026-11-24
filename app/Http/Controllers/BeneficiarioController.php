<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KardexService;
use Illuminate\Support\Facades\DB;
use App\Models\Beneficiario;
use App\Models\EntregaRacion;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Http\Requests\BeneficiarioStoreRequest;
use App\Http\Requests\BeneficiarioUpdateRequest;
use App\Http\Requests\AsistenciaRequest;
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

    public function registrarAsistencia(AsistenciaRequest $request)
    {
        // Validación y mensajes en español en AsistenciaRequest; la cuota sale del padrón
        $validated = $request->validated();

        // Eloquent respeta SoftDeletes: un beneficiario dado de baja no puede registrar asistencia
        $beneficiario = Beneficiario::where('codigo_beneficiario', $validated['codigo_beneficiario'])
            ->where('estado', true)
            ->first();

        if (!$beneficiario) {
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'El código de comensal ingresado no figura como Activo en el padrón.']);
        }

        // Regla 1 (RF-03): una sola asistencia por comensal y por día
        $yaAsistioHoy = EntregaRacion::where('beneficiario_id', $beneficiario->id)
            ->whereDate('fecha_entrega', today())
            ->exists();

        if ($yaAsistioHoy) {
            return redirect()->back()->withInput()->withErrors([
                'duplicado' => "El comensal {$beneficiario->codigo_beneficiario} ya registró su asistencia el día de hoy.",
            ]);
        }

        // Regla 2: límite por persona. No puede retirar más raciones de las autorizadas en el padrón
        if ($validated['raciones_retiradas'] > $beneficiario->raciones_asignadas) {
            return redirect()->back()->withInput()->withErrors([
                'limite_persona' => "El comensal {$beneficiario->codigo_beneficiario} tiene autorizadas "
                    . "{$beneficiario->raciones_asignadas} ración(es) por día y no puede retirar "
                    . "{$validated['raciones_retiradas']}.",
            ]);
        }

        // Solo la Encargada puede exonerar una cuota (control de caja)
        $exonerado = $request->boolean('exonerado');
        if ($exonerado && $request->user()->rol !== 'Encargada') {
            return redirect()->back()->withInput()->withErrors([
                'exoneracion' => 'Solo la Encargada puede autorizar la exoneración de una cuota.',
            ]);
        }

        try {
            $cuotaCobrada = $this->kardexService->registrarEntrega(
                $beneficiario,
                $validated['raciones_retiradas'],
                $exonerado
            );

            return redirect()->back()->with('success', sprintf(
                'Asistencia de %s (%s) registrada: %d ración(es). S/. %s integrados a Caja Chica.',
                $beneficiario->codigo_beneficiario,
                $beneficiario->tipo_comensal,
                $validated['raciones_retiradas'],
                number_format($cuotaCobrada, 2)
            ));
        } catch (UniqueConstraintViolationException $e) {
            // Respaldo del índice UNIQUE (beneficiario_id, fecha_entrega) ante dos envíos simultáneos
            return redirect()->back()->withInput()->withErrors([
                'duplicado' => "El comensal {$beneficiario->codigo_beneficiario} ya registró su asistencia el día de hoy.",
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['limite' => $e->getMessage()]);
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

        public function store(BeneficiarioStoreRequest $request)
    {
        // La validación (y sus mensajes en español) vive en BeneficiarioStoreRequest
        Beneficiario::create($request->validated() + [
            'fecha_incorporacion' => now(),
            'estado'              => true,
        ]);

        return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario creado exitosamente.');
    }

    public function edit($id)
    {
        $beneficiario = Beneficiario::findOrFail($id);
        return view('beneficiarios.edit', compact('beneficiario'));
    }

        public function update(BeneficiarioUpdateRequest $request, $id)
    {
        try {
            $beneficiario = Beneficiario::findOrFail($id);
            $beneficiario->update($request->validated());
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