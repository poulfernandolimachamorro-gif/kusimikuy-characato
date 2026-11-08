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

    // Asistencia: consulta del padrón y registro del marcado diario
    Route::get('/asistencia', [BeneficiarioController::class, 'mostrarAsistencia'])->name('asistencia.index');
    Route::post('/asistencia/registrar', [BeneficiarioController::class, 'registrarAsistencia'])->name('asistencia.store');

    // Kardex: vista del inventario de insumos
    Route::get('/kardex', function () {
        $insumos = \Illuminate\Support\Facades\DB::table('insumos')->get();
        return view('kardex.index', compact('insumos'));
    })->name('kardex.index');

    // Reportes: pantalla principal y descarga en PDF
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');

    // Rutas exclusivas del rol Encargada (control de acceso por rol)
    Route::middleware(['rol:Encargada'])->group(function () {
        // Gestión completa del padrón de beneficiarios (crear, listar, editar y eliminar)
        Route::get('/beneficiarios', [BeneficiarioController::class, 'index'])->name('beneficiarios.index');
        Route::get('/beneficiarios/create', [BeneficiarioController::class, 'create'])->name('beneficiarios.create');
        Route::post('/beneficiarios', [BeneficiarioController::class, 'store'])->name('beneficiarios.store');
        Route::get('/beneficiarios/{id}/edit', [BeneficiarioController::class, 'edit'])->name('beneficiarios.edit');
        Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update'])->name('beneficiarios.update');
        Route::delete('/beneficiarios/{id}', [BeneficiarioController::class, 'destroy'])->name('beneficiarios.destroy');
        
        // Insumos y gastos: CRUD completo, incluida la edición
        Route::resource('insumos', InsumoController::class)->except(['show']);
        Route::resource('gastos', GastoController::class)->except(['show']);
        
        // Lotes, menús y documentos: solo listar, crear y eliminar (sin edición)
        Route::resource('lotes', LoteController::class)->except(['show', 'edit', 'update']);
        Route::resource('menus', MenuController::class)->except(['show', 'edit', 'update']);
        Route::resource('documentos', DocumentoController::class)->except(['show', 'edit', 'update']);
    });

    // Perfil de usuario: edición, actualización y eliminación de la cuenta (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';