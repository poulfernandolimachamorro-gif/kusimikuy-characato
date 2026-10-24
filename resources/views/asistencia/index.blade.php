@extends('layouts.app')

@section('title', 'Control de Asistencia Diaria')

@section('content')
<!-- Encabezado del Módulo con Retorno Seguro -->
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="/dashboard" class="secondary" style="text-decoration: none;"><i class="fa-solid fa-arrow-left fa-lg"></i></a>
    <h2 style="margin: 0;">Módulo de Asistencia Diaria</h2>
</div>

<div class="grid">
    <!-- Bloque Izquierdo: Formulario Operativo de Registro -->
    <article class="card-dinamica">
        <h4 style="margin-bottom: 1.5rem;"><i class="fa-solid fa-user-plus"></i> Registro de Raciones y Liquidación</h4>
        
        <form action="#" method="POST">
            @csrf
            
            <!-- Campo de Búsqueda Predictiva del Comensal -->
            <label for="codigo_beneficiario">
                Código del Beneficiario (Padrón Anonimizado - Ley N° 29733):
                <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                    <input type="text" id="codigo_beneficiario" name="codigo_beneficiario" placeholder="Ej: BEN-CHA-001" required style="margin-bottom: 0;">
                    <button type="button" class="btn-ergonomico" style="padding: 0 1rem;"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </label>

            <!-- Selector Semántico del Tipo de Comensal para Automatización de Tarifas -->
            <fieldset style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                <legend><strong>Tipo de Comensal para Aplicación de Cuota:</strong></legend>
                <label for="socia">
                    <input type="radio" id="socia" name="tipo_comensal" value="Socio/Cocinera" checked>
                    Socio / Cocinera Voluntaria (Cuota Social: **S/. 5.00**)
                </label>
                <label for="publico">
                    <input type="radio" id="publico" name="tipo_comensal" value="Público General">
                    Público General de Characato (Cuota Social: **S/. 8.00**)
                </label>
            </fieldset>

            <!-- Input Numérico Ergonómico de Raciones Autorizadas -->
            <label for="raciones_retiradas">
                Cantidad de Raciones a Retirar:
                <input type="number" id="raciones_retiradas" name="raciones_retiradas" min="1" max="4" value="2" required style="font-size: 1.2rem; font-weight: bold; text-align: center;">
                <small class="secondary">Máximo permitido por grupo familiar según reglamento del Club de Madres.</small>
            </label>

            <!-- Exoneración por Vulnerabilidad Excepcional -->
            <label for="exonerado" style="margin-top: 1.5rem; margin-bottom: 2rem;">
                <input type="checkbox" id="exonerado" name="exonerado" value="1">
                <strong>Exonerar cuota social por vulnerabilidad de extrema urgencia.</strong>
            </label>

            <!-- Botón Principal de Inyección Atómica hacia la Base de Datos -->
            <button type="submit" class="button btn-ergonomico w-100" style="background-color: #38b000; border-color: #38b000; width: 100%;">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Asistencia y Descontar Almacén
            </button>
        </form>
    </article>

    <!-- Bloque Derecho: Panel de Control Perimetral Municipal del Arroz -->
    <article class="card-dinamica" style="border-color: rgba(208, 0, 0, 0.3);">
        <h4 class="text-peligro" style="margin-bottom: 1.5rem;">
            <i class="fa-solid fa-scale-balanced"></i> Control de Porciones Municipales (MPA)
        </h4>
        
        <p class="secondary">
            Regla de control integrada a tu componente backend <code style="color: #ffb703;">KardexService</code> para evitar auditorías u observaciones de los promotores del Estado.
        </p>

        <!-- Barra de Progreso Visual de Consumo Diario -->
        <div style="margin-top: 2rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span style="font-weight: bold;">Gasto de Arroz Acumulado Hoy:</span>
                <span style="font-weight: bold;" class="text-alerta">4.50 kg / 6.00 kg</span>
            </div>
            <!-- Pico CSS Progress Bar -->
            <progress value="4.50" max="6.00" class="warning" style="height: 1.2rem; border-radius: var(--pico-border-radius);"></progress>
        </div>

        <article style="background-color: rgba(255, 183, 3, 0.05); padding: 1rem; border: 1px dashed #ffb703; border-radius: var(--pico-border-radius); margin-top: 1rem;">
            <small style="display: block; line-height: 1.4rem;">
                <i class="fa-solid fa-circle-info text-alerta"></i> <strong>Autonomía Operativa Restante:</strong> Quedan estrictamente <strong>1.50 kg de arroz</strong> para despachos en esta jornada antes de que el framework bloquee automáticamente el controlador mediante una excepción parametrizada en idioma español.
            </small>
        </article>
    </article>
</div>
@endsection
