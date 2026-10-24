@extends('layouts.app')

@section('title', 'Control de Asistencia Diaria')

@section('content')
<!-- Barra superior de navegación interna -->
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
    <a href="/dashboard" class="btn-premium secondary" style="min-height: 40px; padding: 0.5rem 1rem;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
    <h2 style="margin: 0; font-size: 1.8rem;">Control de Asistencia en Línea</h2>
</div>

<div class="grid">
    <!-- Bloque Izquierdo: Formulario Crítico de Persistencia Relacional -->
    <div class="card-moderna">
        <h4 style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.75rem;">
            <i class="fa-solid fa-cash-register" style="color: #1a75ff;"></i> Liquidación Atómica de Raciones
        </h4>
        
        <form action="#" method="POST">
            @csrf
            
            <label for="codigo_beneficiario" style="font-weight: 600;">
                Código Identificador del Comensal:
                <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                    <input type="text" id="codigo_beneficiario" name="codigo_beneficiario" placeholder="Ej: BEN-CHA-024" required style="background: #111827; border: 1px solid rgba(255,255,255,0.1); color: white; margin-bottom: 0;">
                    <button type="button" class="btn-premium" style="min-height: auto; padding: 0 1.2rem;"><i class="fa-solid fa-fingerprint"></i></button>
                </div>
            </label>

            <fieldset style="margin-top: 1.5rem; margin-bottom: 1.5rem; background: rgba(0,0,0,0.15); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.02);">
                <legend style="padding: 0 0.5rem; font-weight: bold; font-size: 0.9rem; color: #94a3b8;">CATEGORÍA DE PADRÓN (TARIFA SOCIAL)</legend>
                <label for="socia" style="margin-bottom: 0.75rem;">
                    <input type="radio" id="socia" name="tipo_comensal" value="Socio/Cocinera" checked>
                    Socia / Madre de Cocina (<span style="color: #38b000; font-weight: bold;">S/. 5.00</span>)
                </label>
                <label for="publico" style="margin: 0;">
                    <input type="radio" id="publico" name="tipo_comensal" value="Público General">
                    Comensal Externo Characato (<span style="color: #1a75ff; font-weight: bold;">S/. 8.00</span>)
                </label>
            </fieldset>

            <label for="raciones_retiradas" style="font-weight: 600;">
                Número de Almuerzos a Retirar:
                <input type="number" id="raciones_retiradas" name="raciones_retiradas" min="1" max="4" value="1" required style="background: #111827; border: 1px solid rgba(255,255,255,0.1); color: white; text-align: center; font-size: 1.2rem; font-weight: bold; margin-top: 0.5rem;">
            </label>

            <label for="exonerado" style="margin-top: 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="exonerado" name="exonerado" value="1" style="margin: 0;">
                <span style="font-size: 0.9rem; color: #cbd5e1;">Exoneración excepcional por vulnerabilidad crítica.</span>
            </label>

            <button type="submit" class="btn-premium" style="width: 100%;">
                <i class="fa-solid fa-circle-check"></i> Registrar Asistencia y Procesar Cobro
            </button>
        </form>
    </div>

    <!-- Bloque Derecho: Panel de Bloqueo del Límite Municipal de Arroz -->
    <div class="card-moderna" style="border-color: rgba(239, 68, 68, 0.15) !important;">
        <h4 style="color: #ff4d4d; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.75rem;">
            <i class="fa-solid fa-scale-balanced" style="filter: drop-shadow(0 0 6px #ff4d4d);"></i> Restricción Operativa Municipal (MPA)
        </h4>
        <p class="subtexto" style="line-height: 1.4rem;">
            Línea de control algorítmico inyectada para evitar suspensiones de víveres por parte de los supervisores de la Municipalidad Provincial de Arequipa.
        </p>

        <!-- Barra de Progreso Avanzada Neon-Style -->
        <div style="margin-top: 2rem; margin-bottom: 1.5rem; background: #111827; padding: 1.25rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.03);">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.9rem;">
                <span style="color: #94a3b8; font-weight: 500;">Consumo de Arroz Hoy:</span>
                <span style="color: #ffb703; font-weight: 700;">4.50 kg / 6.00 kg (Tope Max)</span>
            </div>
            <progress value="4.50" max="6.00" style="height: 14px; border-radius: 20px; box-shadow: 0 0 10px rgba(255,183,3,0.1);"></progress>
        </div>

        <div style="background: rgba(26, 117, 255, 0.04); border: 1px dashed rgba(26, 117, 255, 0.2); padding: 1rem; border-radius: 8px; font-size: 0.85rem; line-height: 1.35rem;" class="subtexto">
            <span style="color: #66b2ff; font-weight: bold;"><i class="fa-solid fa-brain"></i> Capacidad Predictiva del Sistema:</span> 
            Restan exactamente 1.50 kg de grano común. Si la orden actual requiere un volumen superior, la transacción será abortada atómicamente por la capa lógica relacional.
        </div>
    </div>
</div>
@endsection