<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DocumentoController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [InsumoController::class, 'renderDashboard'])->name('dashboard');

    // Módulo Asistencia y Marcado Diario
    Route::get('/asistencia', [BeneficiarioController::class, 'mostrarAsistencia'])->name('asistencia.index');
    Route::post('/asistencia/registrar', [BeneficiarioController::class, 'registrarAsistencia'])->name('asistencia.store');

    // Módulo Kardex de Suministros
    Route::get('/kardex', function () {
        $insumos = \Illuminate\Support\Facades\DB::table('insumos')->get();
        return view('kardex.index', compact('insumos'));
    })->name('kardex.index');

    // Módulo de Reportes Contables
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');

    // Rutas protegidas para Rol Encargada (Matriz de Control RBAC)
    Route::middleware(['rol:Encargada'])->group(function () {
        // CRUD Completo del Padrón de Beneficiarios
        Route::get('/beneficiarios', [BeneficiarioController::class, 'index'])->name('beneficiarios.index');
        Route::get('/beneficiarios/create', [BeneficiarioController::class, 'create'])->name('beneficiarios.create');
        Route::post('/beneficiarios', [BeneficiarioController::class, 'store'])->name('beneficiarios.store');
        Route::get('/beneficiarios/{id}/edit', [BeneficiarioController::class, 'edit'])->name('beneficiarios.edit');
        Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update'])->name('beneficiarios.update');
        Route::delete('/beneficiarios/{id}', [BeneficiarioController::class, 'destroy'])->name('beneficiarios.destroy');
        
        // Entidades con CRUD Real Completo (Insumos y Gastos con Edición Habilitada)
        Route::resource('insumos', InsumoController::class)->except(['show']);
        Route::resource('gastos', GastoController::class)->except(['show']);
        
        // Entidades con Restricción de Acciones de Mutación (Alta, Baja y Consulta)
        Route::resource('lotes', LoteController::class)->except(['show', 'edit', 'update']);
        Route::resource('menus', MenuController::class)->except(['show', 'edit', 'update']);
        Route::resource('documentos', DocumentoController::class)->except(['show', 'edit', 'update']);
    });

    // Rutas del Perfil de Usuario (Breeze Scaffolding)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';