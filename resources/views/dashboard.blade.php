@extends('layouts.app')

@section('title', 'Dashboard Principal')

@section('content')
<!-- Bloque Contextual de Bienvenida -->
<div style="margin-bottom: 2rem;">
    <h2>¡Buen día, Sra. Félipe!</h2>
    <p class="secondary">Jornada de Control Administrativo Operacional — Comedor Popular Characato.</p>
</div>

<!-- Alerta Crítica del Estado de Insumos (Accordion Colapsable para Reducir Carga Cognitiva) -->
<details open style="border: 1px solid #d00000; border-radius: var(--pico-border-radius); margin-bottom: 2rem;">
    <summary style="background-color: rgba(208, 0, 0, 0.1); color: #d00000; font-weight: bold; padding: 0.75rem 1rem;">
        <i class="fa-solid fa-triangle-exclamation"></i> ALERTA CRÍTICA DE ALMACÉN: Insumo Defectuoso Detectado
    </summary>
    <div style="padding: 1rem;">
        <p style="margin-bottom: 0.5rem;">
            <strong>Lote Comprometido:</strong> <code style="color: #ffb703;">L-ARR-02</code> (Arroz Común Municipal).
        </p>
        <p style="margin-bottom: 0;">
            <strong>Detalle de Merma Evaluado:</strong> Grano verde / Tiende a apelmazarse como mazamorra rápido en cocina. Requiere fiscalización de porciones de agua.
        </p>
    </div>
</details>

<!-- Grid Simétrico de Indicadores Estadísticos en Vivo de la Jornada -->
<section class="grid" style="margin-bottom: 2rem;">
    <article class="card-dinamica" style="text-align: center;">
        <p class="secondary" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-users"></i> Padrón de Base</p>
        <h3 style="margin: 0;">80 <small>Familias</small></h3>
    </article>
    <article class="card-dinamica" style="text-align: center;">
        <p class="secondary" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-utensils"></i> Raciones Marcadas</p>
        <h3 style="margin: 0;" class="text-exito">40 <small>Hoy</small></h3>
    </article>
    <article class="card-dinamica" style="text-align: center;">
        <p class="secondary" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-boxes-stacked"></i> Almacén Suministros</p>
        <h3 style="margin: 0;">6 <small>Insumos</small></h3>
    </article>
    <article class="card-dinamica" style="text-align: center;">
        <p class="secondary" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-wallet"></i> Fondo Caja Chica</p>
        <h3 style="margin: 0;" class="text-exito">S/. 150.00</h3>
    </article>
</section>

<hr style="margin-bottom: 2rem;">

<!-- Sección de Navegación de Acciones Logísticas de Alta Ergonomía -->
<h3>Acciones Logísticas Principales</h3>
<div class="grid">
    <a href="/asistencia" class="button btn-ergonomico" style="background-color: #1a75ff; border-color: #1a75ff; text-decoration: none;">
        <i class="fa-solid fa-address-card"></i> Registrar Asistencia y Cuota
    </a>
    <a href="#" class="button secondary btn-ergonomico" role="button">
        <i class="fa-solid fa-boxes-packing"></i> Control de Kardex / Almacén
    </a>
    <a href="#" class="button secondary btn-ergonomico" role="button">
        <i class="fa-solid fa-file-pdf"></i> Exportar Reporte Municipal (MPA)
    </a>
</div>
@endsection
