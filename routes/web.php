<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

// Redirección principal
Route::redirect('/', '/dashboard');

// Rutas del Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Rutas del Módulo de Asistencia
Route::get('/asistencia', function () {
    return view('asistencia.index');
})->name('asistencia.index');

Route::post('/asistencia/registrar', [BeneficiarioController::class, 'store'])->name('asistencia.store');

// Rutas en Desarrollo (Evitan que el Dashboard lance error 500)
Route::get('/kardex', function () {
    return "<h3 style='color:white; text-align:center; margin-top:20vh;'>[Módulo en Desarrollo] Mapeo inmutable de movimientos de stock del Comedor.</h3>";
})->name('kardex.index');

Route::get('/reportes', function () {
    return "<h3 style='color:white; text-align:center; margin-top:20vh;'>[Módulo en Desarrollo] Compilación analítica de informes mensuales para la MPA.</h3>";
})->name('reportes.index');