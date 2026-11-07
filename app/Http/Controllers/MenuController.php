<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MenuReceta;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller {
    public function index() {
        $menus = MenuReceta::all();
        return view('menus.index', compact('menus'));
    }
    public function create() {
        $insumos = DB::table('insumos')->get();
        return view('menus.create', compact('insumos'));
    }
    public function store(Request $request) {
        $request->validate(['nombre_plato' => 'required', 'insumo_id' => 'required', 'gramos_por_racion' => 'required|numeric']);
        MenuReceta::create($request->all());
        return redirect()->route('menus.index')->with('success', 'Receta registrada.');
    }
    public function destroy($id) {
        MenuReceta::findOrFail($id)->delete();
        return redirect()->route('menus.index')->with('success', 'Receta eliminada.');
    }
}