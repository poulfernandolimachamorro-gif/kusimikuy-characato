<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\InsumoController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Asistencia
    Route::get('/asistencia', [BeneficiarioController::class, 'mostrarAsistencia'])->name('asistencia.index');
    Route::post('/asistencia/registrar', [BeneficiarioController::class, 'registrarAsistencia'])->name('asistencia.store');

    // Kardex
    Route::get('/kardex', function () {
        $insumos = \Illuminate\Support\Facades\DB::table('insumos')->get();
        return view('kardex.index', compact('insumos'));
    })->name('kardex.index');

    // Reportes
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');

    // Rutas protegidas para Encargada (CRUD Beneficiarios e Insumos)
    Route::middleware(['rol:Encargada'])->group(function () {
        Route::get('/beneficiarios', [BeneficiarioController::class, 'index'])->name('beneficiarios.index');
        Route::get('/beneficiarios/create', [BeneficiarioController::class, 'create'])->name('beneficiarios.create');
        Route::post('/beneficiarios', [BeneficiarioController::class, 'store'])->name('beneficiarios.store');
        Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update'])->name('beneficiarios.update');
        Route::delete('/beneficiarios/{id}', [BeneficiarioController::class, 'destroy'])->name('beneficiarios.destroy');
        
        Route::resource('insumos', InsumoController::class);
    });

    // Rutas de perfil Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';