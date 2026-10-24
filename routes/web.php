<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

// Redirección automática de la raíz al panel principal
Route::redirect('/', '/dashboard');

// Ruta del Dashboard Principal
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Ruta para visualizar la interfaz de asistencia
Route::get('/asistencia', function () {
    return view('asistencia.index');
})->name('asistencia.index');

// Enlace POST atómico (Corregido sin el .php interno)
Route::post('/asistencia/registrar', [BeneficiarioController::class, 'store'])->name('asistencia.store');
