<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController; // <-- NUEVO: Importación del controlador PDF

Route::get('/', function () {
    return redirect()->route('login');
});

// Todas estas rutas requieren estar logueado (Middleware Auth)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/asistencia', function () {
        return view('asistencia.index');
    })->name('asistencia.index');

    Route::post('/asistencia/registrar', [BeneficiarioController::class, 'store'])->name('asistencia.store');

        Route::get('/kardex', function () {
        $insumos = \Illuminate\Support\Facades\DB::table('insumos')->get();
        return view('kardex.index', compact('insumos'));
    })->name('kardex.index');

    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');

    // Ruta para descargar el PDF real (RF-06)
    Route::get('/reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');

    // Ruta para listar beneficiarios (READ)
    Route::get('/beneficiarios', [BeneficiarioController::class, 'index'])->name('beneficiarios.index');
    
    // Rutas de perfil que trae Breeze por defecto
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';