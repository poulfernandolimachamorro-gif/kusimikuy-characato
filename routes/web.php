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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ControlAsistenciaController;
use App\Http\Controllers\KardexController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas operativas: lista de roles permitidos explícita (decisión de diseño documentada en el informe, 3.2)
    Route::middleware('rol:Encargada,Voluntario')->group(function () {
        Route::get('/asistencia', [BeneficiarioController::class, 'mostrarAsistencia'])->name('asistencia.index');
        Route::post('/asistencia/registrar', [BeneficiarioController::class, 'registrarAsistencia'])->name('asistencia.store');
        Route::get('/asistencia/control', [ControlAsistenciaController::class, 'index'])->name('asistencia.control');
        Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');
    });

    // Rutas protegidas para Rol Encargada (Matriz de Control RBAC)
    Route::middleware(['rol:Encargada'])->group(function () {
        // Módulo de Reportes Contables (flujo de caja: bloqueado para el rol Voluntario)
        Route::get('/reportes', function () {
            return view('reportes.index');
        })->name('reportes.index');
        Route::get('/reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');

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
});

require __DIR__.'/auth.php';