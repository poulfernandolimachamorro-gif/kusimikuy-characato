@extends('layouts.app')

@section('title', 'Dashboard Principal')

@section('content')
<style>
    @keyframes panelFadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animacion-entrada { animation: panelFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }
    .rejilla-metricas { display: grid; grid-template-columns: repeat(2, 1fr) !important; gap: 1.25rem !important; }
    @media (min-width: 992px) { .rejilla-metricas { grid-template-columns: repeat(4, 1fr) !important; gap: 1.75rem !important; } }
    .rejilla-acciones-secundarias { 
        display: grid !important; 
        grid-template-columns: 1fr !important; 
        gap: 1.5rem !important; /* <--- Aumentamos el espacio a 1.5rem */
    }
    @media (min-width: 768px) { 
        .rejilla-acciones-secundarias { 
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important; /* <--- ESTO ARREGLA EL DESBORDE */
        } 
    }
    .tarjeta-analitica { background: rgba(17, 24, 39, 0.7) !important; border: 1px solid rgba(255, 255, 255, 0.05) !important; border-radius: 14px !important; padding: 1.5rem; text-align: center; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .tarjeta-analitica:hover { border-color: rgba(26, 117, 255, 0.3) !important; box-shadow: 0 10px 25px rgba(26, 117, 255, 0.08); transform: translateY(-3px); }
</style>

<div class="animacion-entrada">
    <div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; width: 100%;">
        <div style="max-width: 100%;">
            <h2 style="font-size: 1.8rem; font-weight: 800; margin: 0 0 0.35rem 0; background: linear-gradient(to right, #ffffff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.02em; line-height: 1.2;">
                ¡Bienvenida de vuelta, Sra. Félipe!
            </h2>
            <p class="subtexto" style="margin: 0; font-size: 0.9rem; line-height: 1.4;">
                <i class="fa-solid fa-sliders text-exito"></i> Consola centralizada de micro-gestión para el Comedor Popular Niño Jesús.
            </p>
        </div>
        <div style="background: rgba(34, 197, 94, 0.06); border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.5rem 1.2rem; border-radius: 20px; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem;">
            <span style="width: 8px; height: 8px; background-color: #22c55e; border-radius: 50%; display: inline-block; box-shadow: 0 0 8px #22c55e;"></span>
            <span style="color: #4ade80; font-weight: 700;">Servidor: Sincronizado</span>
        </div>
    </div>

    <details open style="border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 14px; background: rgba(239, 68, 68, 0.02); margin-bottom: 2.5rem; box-shadow: 0 8px 30px rgba(0,0,0,0.3); width: 100%; max-width: 100%; box-sizing: border-box;">
        <summary style="color: #f87171; font-weight: 700; padding: 1.1rem; cursor: pointer; user-select: none; font-size: 1.05rem;">
            <i class="fa-solid fa-triangle-exclamation" style="filter: drop-shadow(0 0 5px #f87171);"></i> 
            ALERTA OPERACIONAL: Evaluación de Calidad de Insumos (Queja de Cocina)
        </summary>
        <div style="padding: 0 1.1rem 1.1rem 1.1rem; border-top: 1px solid rgba(239, 68, 68, 0.08); padding-top: 1rem; margin-top: 0.2rem;">
            <p style="margin: 0 0 0.5rem 0; font-size: 0.95rem;">
                <strong>Lote Fiscalizado por la MPA:</strong> <code style="background: #241818; color: #fca5a5; border: 1px solid rgba(239,68,68,0.2); padding: 0.15rem 0.4rem; border-radius: 4px;">L-ARR-02</code> — Arroz Común Municipal.
            </p>
            <p style="margin: 0; font-size: 0.9rem; line-height: 1.45rem;" class="subtexto">
                <strong>Incidencia de Campo (Sra. María):</strong> Grano con alta tasa de humedad ("arroz verde") propenso a volverse mazamorra rápido. Se exige a las voluntarias de cocina regular el volumen de agua durante la ebullición para resguardar las porciones de los 40 comensales.
            </p>
        </div>
    </details>

    <h3 style="font-size: 0.95rem; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; font-weight: 700;">
        <i class="fa-solid fa-chart-line"></i> Estado Operativo del Comedor
    </h3>
    
    <section class="rejilla-metricas" style="margin-bottom: 3rem;">
        <div class="tarjeta-analitica">
            <p class="subtexto" style="margin: 0 0 0.5rem 0; font-size: 0.85rem;"><i class="fa-solid fa-users"></i> Padrón Oficial</p>
            <h2 style="margin: 0; font-size: 2rem; font-weight: 800; color: #ffffff;">80 <span style="font-size: 0.9rem; color: #64748b; font-weight: 400;">Familias</span></h2>
        </div>
        <div class="tarjeta-analitica">
            <p class="subtexto" style="margin: 0 0 0.5rem 0; font-size: 0.85rem;"><i class="fa-solid fa-utensils text-exito"></i> Raciones Marcadas</p>
            <h2 style="margin: 0; font-size: 2rem; font-weight: 800; color: #4ade80; filter: drop-shadow(0 0 8px rgba(74, 222, 128, 0.25));">40 <span style="font-size: 0.9rem; color: #15803d; font-weight: 600;">Hoy</span></h2>
        </div>
        <div class="tarjeta-analitica">
            <p class="subtexto" style="margin: 0 0 0.5rem 0; font-size: 0.85rem;"><i class="fa-solid fa-boxes-stacked" style="color: #3b82f6;"></i> Insumos Almacén</p>
            <h2 style="margin: 0; font-size: 2rem; font-weight: 800; color: #3b82f6;">6 <span style="font-size: 0.9rem; color: #1d4ed8; font-weight: 600;">Tipos</span></h2>
        </div>
        <div class="tarjeta-analitica">
            <p class="subtexto" style="margin: 0 0 0.5rem 0; font-size: 0.85rem;"><i class="fa-solid fa-wallet"></i> Caja Chica</p>
            <h2 style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #ffffff;">S/. 150<span style="font-size: 0.9rem; color: #64748b; font-weight: 400;">.00</span></h2>
        </div>
    </section>

    <h3 style="font-size: 0.95rem; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; font-weight: 700;">
        <i class="fa-solid fa-gears"></i> Procesos Funcionales Habilitados
    </h3>

    <a href="{{ route('asistencia.index') }}" class="btn-premium" style="width: 100%; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: flex-start; padding: 1.4rem;">
        <i class="fa-solid fa-id-card-clip fa-lg" style="margin-right: 0.5rem;"></i>
        <div style="text-align: left; flex-grow: 1;">
            <span style="display: block; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Registrar Asistencia y Cobro de Cuota Diaria (RF-03)</span>
            <span style="display: block; font-size: 0.8rem; font-weight: 400; color: rgba(255,255,255,0.65); margin-top: 0.15rem;">Interface vinculada a las cuotas diferenciadas fijas automatizadas de S/. 5.00 y S/. 8.00.</span>
        </div>
        <i class="fa-solid fa-chevron-right" style="margin-left: auto;"></i>
    </a>

    <div class="rejilla-acciones-secundarias">
        <a href="{{ route('kardex.index') }}" class="btn-premium secondary" style="display: flex; align-items: center; gap: 0.75rem; justify-content: flex-start; padding: 1.3rem; width: 100%;">
            <i class="fa-solid fa-warehouse fa-lg" style="color: #3b82f6;"></i>
            <div style="text-align: left;">
                <span style="display: block; font-size: 1rem; font-weight: 700; color: #ffffff;">Control de Almacén e Inventarios</span>
                <span style="display: block; font-size: 0.78rem; margin-top: 0.1rem;" class="subtexto">Monitoreo inmutable del Kardex de suministros y mermas físicas.</span>
            </div>
        </a>

        <a href="{{ route('reportes.index') }}" class="btn-premium secondary" style="display: flex; align-items: center; gap: 0.75rem; justify-content: flex-start; padding: 1.3rem; width: 100%;">
            <i class="fa-solid fa-file-pdf fa-lg" style="color: #f87171;"></i>
            <div style="text-align: left;">
                <span style="display: block; font-size: 1rem; font-weight: 700; color: #ffffff;">Exportar Informe Mensual MPA (RF-06)</span>
                <span style="display: block; font-size: 0.78rem; margin-top: 0.1rem;" class="subtexto">Compilación analítica contable automatizada lista para fiscalización.</span>
            </div>
        </a>
    </div>
</div>
@endsection