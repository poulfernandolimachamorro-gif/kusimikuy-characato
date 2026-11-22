<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoteRequest;
use App\Models\LoteInventario;
use Illuminate\Support\Facades\DB;

class LoteController extends Controller {
    public function index() {
        $lotes = LoteInventario::with('insumo')->get();
        return view('lotes.index', compact('lotes'));
    }
    public function create() {
        $insumos = DB::table('insumos')->get();
        return view('lotes.create', compact('insumos'));
    }
    public function store(LoteRequest $request) {
        // La validación (insumo existente y calidad permitida) vive en LoteRequest;
        // validated() evita asignar campos que no pasaron por las reglas
        LoteInventario::create($request->validated());
        return redirect()->route('lotes.index')->with('success', 'Lote registrado.');
    }
    public function destroy($id) {
        LoteInventario::findOrFail($id)->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado.');
    }
}