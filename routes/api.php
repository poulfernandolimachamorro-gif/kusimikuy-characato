<?php

use App\Http\Controllers\BeneficiarioController;
use App\Services\KardexService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de la API - KusiMikuy Characato
|--------------------------------------------------------------------------
*/

// CRUD del padrón de beneficiarios (las bajas lógicas se filtran automáticamente)
Route::apiResource('beneficiarios', BeneficiarioController::class);

/**
 * Registra las salidas de insumos de la cocina y controla el límite de arroz.
 * Avisa cuando se alcanza el tope fijado por la Municipalidad Provincial de Arequipa (MPA).
 */
Route::post('/kardex/salida-cocina', function (Request $request, KardexService $kardexService) {
    
    $validated = $request->validate([
        'beneficiario_id' => 'required|integer|exists:beneficiarios,id',
        'cantidad_kg'     => 'required|numeric|min:0.01',
        'motivo_detalle'  => 'nullable|string|max:200'
    ]);

    try {
        // Llama a la lógica del servicio KardexService
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
        // Si se supera el tope de 6 kg, devuelve el mensaje de error en español
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 422);
    }
});