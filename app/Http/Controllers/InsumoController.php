<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsumoController extends Controller
{
    public function index() {
        $insumos = DB::table('insumos')->get();
        return view('insumos.index', compact('insumos'));
    }
    
    public function create() {
        return view('insumos.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'nombre_insumo' => 'required|string|max:100',
            'stock_actual' => 'required|numeric|min:0',
            'unidad_medida' => 'required|in:Kilogramos,Litros,Unidades,Sacos',
        ]);
        DB::table('insumos')->insert([
            'nombre_insumo' => $request->nombre_insumo,
            'stock_actual' => $request->stock_actual,
            'stock_minimo_alerta' => 10,
            'limite_consumo_diario' => null, // el tope de 6 kg aplica solo al Arroz Común (ver DatabaseSeeder)
            'unidad_medida' => $request->unidad_medida,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('insumos.index')->with('success', 'Insumo registrado.');
    }

    public function edit($id) {
        $insumo = DB::table('insumos')->where('id', $id)->first();
        if (!$insumo) abort(404);
        return view('insumos.edit', compact('insumo'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nombre_insumo' => 'required|string|max:100',
            'stock_actual' => 'required|numeric|min:0',
            'unidad_medida' => 'required|in:Kilogramos,Litros,Unidades,Sacos',
        ]);
        DB::table('insumos')->where('id', $id)->update([
            'nombre_insumo' => $request->nombre_insumo,
            'stock_actual' => $request->stock_actual,
            'unidad_medida' => $request->unidad_medida,
            'updated_at' => now(),
        ]);
        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente.');
    }
    
    public function destroy($id) {
        DB::table('insumos')->where('id', $id)->delete();
        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado.');
    }
}