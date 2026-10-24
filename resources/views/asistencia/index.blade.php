@extends('layouts.app')

@section('title', 'Control de Asistencia Diaria')

@section('content')
<!-- Contenedor del Bloque de Estilos Avanzados e Interactividad de Neón -->
<style>
    /* Animación de Entrada Suave (Glass Fade In) */
    @keyframes moduloFadeInUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animar-modulo {
        animation: moduloFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    /* Clases de Control para Inputs Ergonómicos */
    .input-premium-asistencia {
        background-color: #111827 !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
        border-radius: 10px !important;
        padding: 0.85rem 1.2rem !important;
        font-size: 1rem !important;
        transition: all 0.25s ease-image !important;
        margin-bottom: 0 !important;
    }
    .input-premium-asistencia:focus {
        border-color: #1a75ff !important;
        box-shadow: 0 0 14px rgba(26, 117, 255, 0.25) !important;
        background-color: #151f32 !important;
    }

    /* Contenedor de Botones de Radio Adaptativos */
    .contenedor-tarifas-sociales {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        margin: 1.25rem 0;
    }
    
    .opcion-tarifa-tarjeta {
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: 1rem 1.25rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 0.85rem;
        user-select: none;
    }
    .opcion-tarifa-tarjeta:hover {
        background: rgba(26, 117, 255, 0.05);
        border-color: rgba(26, 117, 255, 0.25);
        transform: translateX(3px);
    }

    /* Rejilla Adaptativa Avanzada de Dos Columnas en PC y Una en Móviles */
    .rejilla-asistencia-dinamica {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        align-items: start;
    }
    @media (min-width: 992px) {
        .rejilla-asistencia-dinamica {
            grid-template-columns: 1.25fr 0.75fr !important;
        }
    }

    /* Estilización del Input Numérico */
    .input-numerico-ergonomico {
        text-align: center;
        font-size: 1.3rem !important;
        font-weight: 800 !important;
        letter-spacing: 0.05em;
    }

    /* Efecto de barra de progreso neón */
    progress::-webkit-progress-value {
        background: linear-gradient(90deg, #eab308, #f59e0b) !important;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
    }
</style>

<div class="animar-modulo">
    <!-- Barra Superior de Navegación de Alta Usabilidad (Cumple WCAG) -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2.5rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="/dashboard" class="btn-premium secondary" style="min-height: auto; height: 42px; padding: 0 1.1rem; border-radius: 8px !important;" title="Retornar al Consola Administrativa">
                <i class="fa-solid fa-arrow-left-long"></i> Volver
            </a>
            <h2 style="margin: 0; font-size: 1.85rem; font-weight: 800; letter-spacing: -0.02em; color: #ffffff;">Control de Asistencia y Marcado</h2>
        </div>
        <div class="subtexto" style="font-size: 0.9rem; font-weight: 600; background: rgba(255,255,255,0.03); padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
            <i class="fa-solid fa-calendar-check text-exito"></i> Jornada: {{ date('d/m/2026') }}
        </div>
    </div>

    <!-- Rejilla Maestra de Presentación Controlada -->
    <div class="rejilla-asistencia-dinamica">
        
        <!-- SECCIÓN IZQUIERDA: Formulario Operativo Atómico (Conectado al Controlador) -->
        <div class="card-moderna">
            <h4 style="margin-bottom: 1.5rem; font-size: 1.25rem; display: flex; align-items: center; gap: 0.6rem; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 0.75rem;">
                <i class="fa-solid fa-cash-register" style="color: #1a75ff; filter: drop-shadow(0 0 6px rgba(26,117,255,0.3));"></i> Liquidación de Raciones de Padrón
            </h4>
            
            <!-- Inyección Atómica hacia la Ruta POST Corregida del Servidor -->
            <form action="{{ route('asistencia.store') }}" method="POST">
                @csrf
                
                <!-- Entrada de Búsqueda Relacional del Beneficiario (Ley N° 29733) -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="codigo_beneficiario" style="font-weight: 600; margin-bottom: 0.5rem; display: block; font-size: 0.95rem; color: #cbd5e1;">
                        Código Identificador del Comensal (Padrón Oficial - 80 Base):
                    </label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" id="codigo_beneficiario" name="codigo_beneficiario" class="input-premium-asistencia" placeholder="Ej: BEN-CHA-024" required style="flex-grow: 1;">
                        <button type="button" class="btn-premium" style="min-height: auto; padding: 0 1.25rem; border-radius: 10px !important;" title="Buscar en Base de Datos">
                            <i class="fa-solid fa-fingerprint"></i>
                        </button>
                    </div>
                    <small class="subtexto" style="margin-top: 0.45rem; display: block;">El motor realiza una consulta parametrizada sobre las 80 familias registradas.</small>
                </div>

                <!-- Tarifas Sociales Diferenciadas (Cumple Requerimiento Funcional RF-03) -->
                <div style="margin-bottom: 1.5rem;">
                    <span style="font-weight: 600; font-size: 0.95rem; color: #cbd5e1; display: block;">Categoría de Comensal para Aplicación de Cuota:</span>
                    <div class="contenedor-tarifas-sociales">
                        <label class="opcion-tarifa-tarjeta" for="socia">
                            <input type="radio" id="socia" name="tipo_comensal" value="Socio/Cocinera" checked style="margin: 0; width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <strong style="color: #ffffff; font-size: 0.95rem;">Socia / Madre de Cocina Voluntaria</strong>
                                <span style="display: block; font-size: 0.82rem; margin-top: 0.1rem;" class="text-exito">Cuota de recuperación social: S/. 5.00 por ración</span>
                            </div>
                        </label>
                        <label class="opcion-tarifa-tarjeta" for="publico">
                            <input type="radio" id="publico" name="tipo_comensal" value="Público General" style="margin: 0; width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <strong style="color: #ffffff; font-size: 0.95rem;">Público General / Vecino de Characato</strong>
                                <span style="display: block; font-size: 0.82rem; margin-top: 0.1rem; color: #66b2ff;">Cuota estándar de sostenibilidad: S/. 8.00 por ración</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Selección Numérica de Raciones con Área Táctil WCAG -->
                <div style="margin-bottom: 1.75rem;">
                    <label for="raciones_retiradas" style="font-weight: 600; margin-bottom: 0.5rem; display: block; font-size: 0.95rem; color: #cbd5e1;">
                        Cantidad de Almuerzos Autorizados a Retirar:
                    </label>
                    <input type="number" id="raciones_retiradas" name="raciones_retiradas" class="input-premium-asistencia input-numerico-ergonomico" min="1" max="4" value="1" required style="width: 100%;">
                    <small class="subtexto" style="margin-top: 0.45rem; display: block;">Límite normativo de un máximo de 4 porciones por ficha de grupo familiar.</small>
                </div>

                <!-- Exoneración Excepcional por Vulnerabilidad Crítica -->
                <div style="margin-bottom: 2.5rem; background: rgba(250, 204, 21, 0.02); padding: 0.85rem 1.1rem; border-radius: 10px; border: 1px dashed rgba(250, 204, 21, 0.18);">
                    <label for="exonerado" style="display: flex; align-items: center; gap: 0.65rem; margin: 0; cursor: pointer; user-select: none;">
                        <input type="checkbox" id="exonerado" name="exonerado" value="1" style="margin: 0; width: 16px; height: 16px;">
                        <span style="font-size: 0.9rem; font-weight: 600; color: #facc15;">Exonerar cuota social por condición de extrema urgencia económica.</span>
                    </label>
                </div>

                <!-- Botón de Ejecución Transaccional del Formulario -->
                <button type="submit" class="btn-premium" style="width: 100%; border-radius: 12px !important;">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Guardar Asistencia y Procesar Salida
                </button>
            </form>
        </div>

        <!-- SECCIÓN DERECHA: Restricción del Límite de Arroz Municipal (Cumple RF-04) -->
        <div class="card-moderna" style="border-color: rgba(239, 68, 68, 0.12) !important; background: rgba(15, 21, 32, 0.6) !important;">
            <h4 style="color: #f87171; margin-bottom: 1.5rem; font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 0.75rem;">
