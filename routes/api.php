<?php

use App\Http\Controllers\BeneficiarioController;
use App\Services\KardexService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - KusiMikuy Characato
|--------------------------------------------------------------------------
*/

// Endpoints del CRUD del Padrón de Beneficiarios (Filtra de forma nativa bajas lógicas)
Route::apiResource('beneficiarios', BeneficiarioController::class);

/**
 * Endpoint de Negocio: Registro de consumos y control estricto del límite de arroz.
 * Alerata el umbral rígido fiscalizado por la Municipalidad Provincial de Arequipa (MPA).
 */
Route::post('/kardex/salida-cocina', function (Request $request, KardexService $kardexService) {
    
    $validated = $request->validate([
        'beneficiario_id' => 'required|integer|exists:beneficiarios,id',
        'cantidad_kg'     => 'required|numeric|min:0.01',
        'motivo_detalle'  => 'nullable|string|max:200'
    ]);

    try {
        // Invoca el algoritmo alojado en la capa de servicios desacoplada
        $movimiento = $kardexService->registrarSalidaCocina(
            $validated['beneficiario_id'],
            $validated['cantidad_kg'],
            $validated['motivo_detalle']
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Despacho de insumos procesado correctamente.',
            'data'    => $movimiento
        ], 201);

    } catch (\Exception $e) {
        // Intercepta el bloqueo preventivo del tope de 6 kg y remite la excepción en español
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 422);
    }
});