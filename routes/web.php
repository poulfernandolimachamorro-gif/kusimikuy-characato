<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Todas estas rutas requieren estar logueado (Middleware Auth)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // RUTA CORREGIDA: Llama al controlador para calcular el arroz
    Route::get('/asistencia', [BeneficiarioController::class, 'mostrarAsistencia'])->name('asistencia.index');

    // Ruta para guardar la asistencia (POST)
    Route::post('/asistencia/registrar', [BeneficiarioController::class, 'store'])->name('asistencia.store');

    // Ruta del Kardex con datos reales
    Route::get('/kardex', function () {
        $insumos = \Illuminate\Support\Facades\DB::table('insumos')->get();
        return view('kardex.index', compact('insumos'));
    })->name('kardex.index');

    // Rutas de Reportes
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');

    Route::get('/reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');

    // Rutas de Beneficiarios (CRUD)
    Route::get('/beneficiarios', [BeneficiarioController::class, 'index'])->name('beneficiarios.index');
    Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update'])->name('beneficiarios.update');
    Route::delete('/beneficiarios/{id}', [BeneficiarioController::class, 'destroy'])->name('beneficiarios.destroy');
    
    // Rutas de perfil que trae Breeze por defecto
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';