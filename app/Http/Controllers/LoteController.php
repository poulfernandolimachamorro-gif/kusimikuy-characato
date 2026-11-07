<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LoteInventario;
use App\Models\Insumo;

class LoteController extends Controller {
    public function index() {
        $lotes = LoteInventario::with('insumo')->get();
        return view('lotes.index', compact('lotes'));
    }
    public function create() {
        $insumos = \Illuminate\Support\Facades\DB::table('insumos')->get();
        return view('lotes.create', compact('insumos'));
    }
    public function store(Request $request) {
        $request->validate(['insumo_id' => 'required', 'codigo_lote' => 'required', 'estado_calidad' => 'required']);
        LoteInventario::create($request->all());
        return redirect()->route('lotes.index')->with('success', 'Lote registrado.');
    }
    public function destroy($id) {
        LoteInventario::findOrFail($id)->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado.');
    }
}