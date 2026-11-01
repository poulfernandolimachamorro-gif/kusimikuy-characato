<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/asistencia', function () {
    return view('asistencia.index');
})->name('asistencia.index');

Route::post('/asistencia/registrar', [BeneficiarioController::class, 'store'])->name('asistencia.store');

// Rutas hacia las vistas elegantes
Route::get('/kardex', function () {
    return view('kardex.index');
})->name('kardex.index');

Route::get('/reportes', function () {
    return view('reportes.index');
})->name('reportes.index');