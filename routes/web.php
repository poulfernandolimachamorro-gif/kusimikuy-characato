<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

// Redirección principal
Route::redirect('/', '/dashboard');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Módulo de Asistencia
Route::get('/asistencia', function () {
    return view('asistencia.index');
})->name('asistencia.index');

Route::post('/asistencia/registrar', [BeneficiarioController::class, 'store'])->name('asistencia.store');

// Módulos que ya no son texto plano, ahora son vistas elegantes
Route::get('/kardex', function () {
    return view('kardex.index');
})->name('kardex.index');

Route::get('/reportes', function () {
    return view('reportes.index');
})->name('reportes.index');