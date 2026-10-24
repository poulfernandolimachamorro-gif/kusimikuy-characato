@extends('layouts.app')

@section('title', 'Dashboard Principal')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <h2 style="font-size: 2.2rem; margin-bottom: 0.25rem;">¡Bienvenida de vuelta!</h2>
    <p class="subtexto">Consola de micro-gestión diaria y fiscalización de raciones de cocina.</p>
</div>

<!-- Alerta de Almacén con Animación y Borde de Neón Opaco -->
<details open style="border: 1px solid rgba(208, 0, 0, 0.4); border-radius: 12px; background: rgba(208, 0, 0, 0.03); margin-bottom: 2.5rem; box-shadow: 0 4px 20px rgba(208, 0, 0, 0.15);">
    <summary style="color: #ff4d4d; font-weight: 700; padding: 1rem; cursor: pointer; user-select: none;">
        <i class="fa-solid fa-triangle-exclamation" style="filter: drop-shadow(0 0 6px #ff4d4d);"></i> ALERTA CRÍTICA: Insumo Defectuoso en Stock
    </summary>
    <div style="padding: 0 1rem 1rem 1rem; border-top: 1px solid rgba(208, 0, 0, 0.1); pt: 1rem; margin-top: 0.5rem;">
        <p style="margin-bottom: 0.5rem; font-size: 0.95rem;">
            <strong>Lote:</strong> <code style="background: #2a1b1b; color: #ff9999; border: 1px solid rgba(255,0,0,0.2);">L-ARR-02</code> — Arroz Común Provincial.
        </p>
        <p style="margin: 0; font-size: 0.95rem;" class="subtexto">
            Reporte de la Sra. María: Grano verde con tendencia a volverse "mazamorra". Se exige regular el volumen de agua durante el graneado para evitar mermas físicas.
        </p>
    </div>
</details>

<!-- Rejilla de Métricas Modernizadas -->
<h3 style="font-size: 1.3rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Estadísticas Operativas</h3>
<section class="grid" style="margin-bottom: 3rem;">
    <div class="card-moderna" style="text-align: center;">
        <p class="subtexto" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-id-card-clip"></i> Familias Adscritas</p>
        <h2 style="margin: 0; font-size: 2.5rem; color: #ffffff;">80</h2>
    </div>
    <div class="card-moderna" style="text-align: center;">
        <p class="subtexto" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-circle-check" style="color: #38b000;"></i> Asistencia Hoy</p>
        <h2 style="margin: 0; font-size: 2.5rem; color: #38b000; filter: drop-shadow(0 0 10px rgba(56, 176, 0, 0.3));">40</h2>
    </div>
    <div class="card-moderna" style="text-align: center;">
        <p class="subtexto" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-box" style="color: #1a75ff;"></i> Insumos Almacén</p>
        <h2 style="margin: 0; font-size: 2.5rem; color: #1a75ff;">6</h2>
    </div>
    <div class="card-moderna" style="text-align: center;">
        <p class="subtexto" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-cash-register"></i> Balance de Caja</p>
        <h2 style="margin: 0; font-size: 2.5rem; color: #ffffff;">S/. 150</h2>
    </div>
</section>

<!-- Panel de Control Operativo con Botones de Gran Tamaño interactivos -->
<h3 style="font-size: 1.3rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Acciones Principales</h3>
<div class="grid">
    <a href="/asistencia" class="btn-premium">
        <i class="fa-solid fa-clipboard-user"></i> Registrar Asistencia y Cuota
    </a>
    <a href="#" class="btn-premium secondary" role="button">
        <i class="fa-solid fa-boxes-stacked"></i> Movimientos de Kardex
    </a>
    <a href="#" class="btn-premium secondary" role="button">
        <i class="fa-solid fa-file-invoice-dollar"></i> Rendición de Cuentas (PDF)
    </a>
</div>
@endsection