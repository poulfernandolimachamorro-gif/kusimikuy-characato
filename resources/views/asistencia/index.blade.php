@extends('layouts.app')

@section('title', 'Asistencia Diaria')

@section('content')
<!-- Bloque CSS Dedicado: Evita cruces lógicos y gestiona las animaciones de cristal -->
<style>
    @keyframes moduloSlideIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .contenedor-animado {
        animation: moduloSlideIn 0.40s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    /* Caja con Efecto de Cristal Fluido (Glassmorphism) */
    .caja-cristal {
        background: rgba(18, 24, 38, 0.65) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 14px !important;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    /* Estructura responsiva blindada */
    .flex-asistencia {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }
    @media (min-width: 992px) {
        .flex-asistencia {
            flex-direction: row !important;
        }
        .col-formulario { flex: 1.2; }
        .col-restriccion { flex: 0.8; }
    }

    .input-asistencia-premium {
        background-color: #0f1422 !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        padding: 0.75rem 1rem !important;
        font-size: 0.95rem !important;
        margin-bottom: 0 !important;
        width: 100%;
    }
    .input-asistencia-premium:focus {
        border-color: #1a75ff !important;
        box-shadow: 0 0 12px rgba(26, 117, 255, 0.2) !important;
    }

    .tarjeta-radio-social {
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: 0.85rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        user-select: none;
        margin-bottom: 0.75rem;
    }
    .tarjeta-radio-social:hover {
        background: rgba(26, 117, 255, 0.03);
        border-color: rgba(26, 117, 255, 0.15);
    }

    progress.barra-progreso-neon {
        height: 10px;
        border-radius: 10px;
        background-color: #161f30 !important;
        border: none;
        width: 100%;
        display: block;
        margin-top: 0.5rem;
    }
    progress.barra-progreso-neon::-webkit-progress-value {
        background: linear-gradient(90deg, #eab308, #f59e0b) !important;
        border-radius: 10px;
    }
</style>

<div class="contenedor-animado">
    <!-- Fila Superior de Navegación del Módulo -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="/dashboard" class="btn-premium secondary">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
            <h3 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.01em;">Control de Asistencia y Marcado</h3>
        </div>
        <div class="subtexto" style="font-weight: 600; background: rgba(255,255,255,0.02); padding: 0.4rem 0.8rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.04);">
            <i class="fa-solid fa-calendar text-exito"></i> Fecha: 24/10/2026
        </div>
    </div>

    <!-- Contenedor Flex Adaptativo Ajustado -->
    <div class="flex-asistencia">
        
        <!-- COLUMNA IZQUIERDA: Formulario de Registro -->
        <div class="col-formulario">
            <div class="caja-cristal">
                <h4 style="margin: 0 0 1.25rem 0; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 0.5rem;">
                    <i class="fa-solid fa-cash-register" style="color: #1a75ff;"></i> Liquidación de Raciones de Padrón
                </h4>
                
                <form action="#" method="POST" onsubmit="event.preventDefault();">
                    @csrf
                    
                    <!-- Campo 1: Código Anonimizado (Ley 29733) -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="codigo_beneficiario" style="font-weight: 600; margin-bottom: 0.4rem; display: block; font-size: 0.9rem; color: #cbd5e1;">
                            Código Identificador del Comensal (80 Base):
                        </label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" id="codigo_beneficiario" name="codigo_beneficiario" class="input-asistencia-premium" placeholder="Ej: BEN-CHA-024" required style="flex-grow: 1;">
                            <button type="button" class="btn-premium" style="min-height: auto; width: 50px; padding: 0; border-radius: 8px !important;">
                                <i class="fa-solid fa-fingerprint"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Campo 2: Tarifas Sociales (RF-03) -->
                    <div style="margin-bottom: 1.25rem;">
                        <span style="font-weight: 600; font-size: 0.9rem; color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Categoría para Aplicación de Cuota:</span>
                        
                        <label class="tarjeta-radio-social" for="socia">
                            <input type="radio" id="socia" name="tipo_comensal" value="Socio/Cocinera" checked style="margin: 0; width: 16px; height: 16px; cursor: pointer;">
                            <div>
                                <strong style="color: #ffffff; font-size: 0.9rem; display: block;">Socia / Madre de Cocina Voluntaria</strong>
                                <span style="font-size: 0.8rem;" class="text-exito">Cuota social: S/. 5.00 por ración</span>
                            </div>
                        </label>

                        <label class="tarjeta-radio-social" for="publico">
                            <input type="radio" id="publico" name="tipo_comensal" value="Público General" style="margin: 0; width: 16px; height: 16px; cursor: pointer;">
                            <div>
                                <strong style="color: #ffffff; font-size: 0.9rem; display: block;">Público General / Vecino Externo</strong>
                                <span style="font-size: 0.8rem; color: #66b2ff;">Cuota estándar: S/. 8.00 por ración</span>
                            </div>
                        </label>
                    </div>

                    <!-- Campo 3: Cantidad Numérica -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="raciones_retiradas" style="font-weight: 600; margin-bottom: 0.4rem; display: block; font-size: 0.9rem; color: #cbd5e1;">
                            Cantidad de Almuerzos a Retirar:
                        </label>
                        <input type="number" id="raciones_retiradas" name="raciones_retiradas" class="input-asistencia-premium" min="1" max="4" value="1" required>
                    </div>

                    <!-- Campo 4: Exoneración -->
                    <div style="margin-bottom: 1.75rem; background: rgba(250, 204, 21, 0.02); padding: 0.75rem 1rem; border-radius: 8px; border: 1px dashed rgba(250, 204, 21, 0.15);">
                        <label for="exonerado" style="display: flex; align-items: center; gap: 0.5rem; margin: 0; cursor: pointer; user-select: none;">
                            <input type="checkbox" id="exonerado" name="exonerado" value="1" style="margin: 0; width: 15px; height: 15px;">
                            <span style="font-size: 0.85rem; font-weight: 600; color: #facc15;">Exonerar cuota por vulnerabilidad extrema.</span>
                        </label>
                    </div>

                    <button type="button" class="btn-premium">
                        <i class="fa-solid fa-check"></i> Guardar Asistencia y Procesar Salida
                    </button>
                </form>
            </div>
        </div>

        <!-- COLUMNA DERECHA: Restricción del Límite de Arroz (RF-04) -->
        <div class="col-restriccion">
            <div class="caja-cristal" style="border-color: rgba(239, 68, 68, 0.12) !important;">
                <h4 style="color: #f87171; margin: 0 0 1rem 0; font-size: 1.1rem; display: flex; align-items: center; gap: 0.4rem; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 0.5rem;">
                    <i class="fa-solid fa-scale-balanced"></i> Restricción Municipal MPA
                </h4>
                
                <p class="subtexto" style="line-height: 1.35rem; font-size: 0.85rem; margin: 0 0 1.25rem 0;">
                    Tope estricto fiscalizado por la **Municipalidad Provincial de Arequipa**. Evita observaciones administrativas controlando el consumo diario acumulado de arroz del comedor.
                </p>

                <div style="background: #090d16; padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.02); margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 600;">
                        <span style="color: #94a3b8;">Gasto de Arroz Hoy:</span>
                        <span style="color: #facc15;">4.50 kg / 6.00 kg</span>
                    </div>
                    <progress value="4.50" max="6.00" class="barra-progreso-neon"></progress>
                </div>

