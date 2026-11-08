<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastoController extends Controller
{
    public function index() {
        $gastos = DB::table('gastos')->orderBy('fecha_gasto', 'desc')->get();
        return view('gastos.index', compact('gastos'));
    }
    
    public function create() {
        return view('gastos.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'concepto' => 'required|string|max:200',
            'monto' => 'required|numeric|min:0.01',
            'fecha_gasto' => 'required|date',
        ]);
        DB::table('gastos')->insert([
            'concepto' => $request->concepto,
            'monto' => $request->monto,
            'tipo_comprobante' => 'Boleta',
            'fecha_gasto' => $request->fecha_gasto,
            'usuario_id' => auth()->id() ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('gastos.index')->with('success', 'Gasto registrado.');
    }

    public function edit($id) {
        $gasto = DB::table('gastos')->where('id', $id)->first();
        if (!$gasto) abort(404);
        return view('gastos.edit', compact('gasto'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'concepto' => 'required|string|max:200',
            'monto' => 'required|numeric|min:0.01',
            'fecha_gasto' => 'required|date',
        ]);
        DB::table('gastos')->where('id', $id)->update([
            'concepto' => $request->concepto,
            'monto' => $request->monto,
            'fecha_gasto' => $request->fecha_gasto,
            'updated_at' => now(),
        ]);
        return redirect()->route('gastos.index')->with('success', 'Gasto actualizado correctamente.');
    }
    
    public function destroy($id) {
        DB::table('gastos')->where('id', $id)->delete();
        return redirect()->route('gastos.index')->with('success', 'Gasto eliminado.');
    }
}