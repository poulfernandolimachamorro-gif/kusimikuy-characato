<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsumoRequest;
use Illuminate\Support\Facades\DB;

class InsumoController extends Controller
{
    /**
     * Insumo fiscalizado por la MPA (tope de 6.00 kg diarios, RF-04). KardexService lo busca
     * por este nombre y calcula en kilogramos, por lo que no se puede renombrar ni eliminar.
     */
    private const INSUMO_PROTEGIDO = 'Arroz Común';

    public function index() {
        $insumos = DB::table('insumos')->get();
        return view('insumos.index', compact('insumos'));
    }
    
    public function create() {
        return view('insumos.create');
    }
    
    public function store(InsumoRequest $request) {
        // La validación vive en InsumoRequest
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

    public function update(InsumoRequest $request, $id) {
        $insumo = DB::table('insumos')->where('id', $id)->first();
        if (!$insumo) abort(404);

        // Del Arroz Común solo se puede actualizar el stock (nombre y unidad quedan fijos)
        if ($insumo->nombre_insumo === self::INSUMO_PROTEGIDO
            && ($request->nombre_insumo !== self::INSUMO_PROTEGIDO || $request->unidad_medida !== 'Kilogramos')) {
            return redirect()->back()->withInput()->withErrors([
                'protegido' => '«Arroz Común» es el insumo fiscalizado por la MPA: no se puede renombrar ni cambiar su unidad (Kilogramos). Solo puede actualizar su stock.',
            ]);
        }

        DB::table('insumos')->where('id', $id)->update([
            'nombre_insumo' => $request->nombre_insumo,
            'stock_actual' => $request->stock_actual,
            'unidad_medida' => $request->unidad_medida,
            'updated_at' => now(),
        ]);
        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente.');
    }
    
    public function destroy($id) {
        $insumo = DB::table('insumos')->where('id', $id)->first();
        if (!$insumo) abort(404);

        if ($insumo->nombre_insumo === self::INSUMO_PROTEGIDO) {
            return redirect()->route('insumos.index')->withErrors([
                'protegido' => '«Arroz Común» no se puede eliminar: es el insumo fiscalizado por el tope municipal de 6.00 kg diarios.',
            ]);
        }

        DB::table('insumos')->where('id', $id)->delete();
        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado.');
    }
}