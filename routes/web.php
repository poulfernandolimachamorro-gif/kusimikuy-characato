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

// Placeholders limpios usando el layout base
Route::get('/kardex', function () {
    return "<body style='background-color:#070a12; color:white; font-family:sans-serif;'><h3 style='text-align:center; margin-top:30vh;'>📦 [Módulo en Desarrollo - Semana 11]<br><span style='font-weight:300; font-size:1rem; color:#94a3b8;'>Mapeo inmutable de movimientos de stock del Comedor Popular.</span></h3><p style='text-align:center;'><a href='/dashboard' style='color:#1a75ff; text-decoration:none;'>← Volver al Dashboard</a></p></body>";
})->name('kardex.index');

Route::get('/reportes', function () {
    return "<body style='background-color:#070a12; color:white; font-family:sans-serif;'><h3 style='text-align:center; margin-top:30vh;'>📄 [Módulo en Desarrollo - Semana 11]<br><span style='font-weight:300; font-size:1rem; color:#94a3b8;'>Compilación analítica de informes mensuales para la MPA (PDF).</span></h3><p style='text-align:center;'><a href='/dashboard' style='color:#1a75ff; text-decoration:none;'>← Volver al Dashboard</a></p></body>";
})->name('reportes.index');