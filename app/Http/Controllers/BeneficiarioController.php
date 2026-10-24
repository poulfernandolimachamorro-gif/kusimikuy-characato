<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BeneficiarioController extends Controller
{
    /**
     * Muestra el padrón de beneficiarios activos (Filtra bajas lógicas automáticamente).
     */
    public function index(): JsonResponse
    {
        $beneficiarios = Beneficiario::where('estado', true)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $beneficiarios
        ], 200);
    }

    /**
     * Registra un comensal anonimizado cumpliendo la Ley N° 29733 en MySQL.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'codigo_beneficiario'  => 'required|string|max:20|unique:beneficiarios,codigo_beneficiario',
            'tipo_comensal'        => 'required|in:Socio/Cocinera,Público General',
            'cantidad_integrantes' => 'required|integer|min:1',
            'raciones_asigandas'   => 'required|integer|min:1',
            'fecha_incorporacion'  => 'required|date',
        ]);

        $beneficiario = Beneficiario::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Beneficiario registrado correctamente en el padrón de Characato.',
            'data'    => $beneficiario
        ], 211);
    }

    /**
     * Ejecuta la baja lógica (SoftDeletes) solicitada por la rúbrica del profesor.
     */
    public function destroy(int $id): JsonResponse
    {
        $beneficiario = Beneficiario::findOrFail($id);
        
        // Ejecuta el borrado lógico sin destruir filas de auditoría municipal
        $beneficiario->delete(); 

        return response()->json([
            'status'  => 'success',
            'message' => 'El comensal ha sido dado de baja lógica en el sistema correctamente.'
        ], 200);
    }
}