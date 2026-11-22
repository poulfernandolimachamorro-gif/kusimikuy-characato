<?php
namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
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
    public function store(MenuRequest $request) {
        // La validación vive en MenuRequest; validated() solo entrega los campos permitidos
        MenuReceta::create($request->validated());
        return redirect()->route('menus.index')->with('success', 'Receta registrada.');
    }
    public function destroy($id) {
        MenuReceta::findOrFail($id)->delete();
        return redirect()->route('menus.index')->with('success', 'Receta eliminada.');
    }
}