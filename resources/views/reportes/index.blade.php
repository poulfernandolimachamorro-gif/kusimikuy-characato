@extends('layouts.app')

@section('title', 'Reportes MPA')

@section('content')
<div class="caja-cristal" style="max-width: 640px; margin: 0 auto; text-align: center;">
    <i class="fa-solid fa-file-pdf" style="font-size: 3rem; color: #f87171; margin-bottom: 1rem;"></i>
    <h2 style="color: white; font-weight: 800;">Exportación de Informe Mensual MPA</h2>
    <p class="subtexto" style="margin-bottom: 1.5rem;">
        Rendición de cuentas del mes elegido: ingresos, gastos, consumo de arroz del Kardex y mermas,
        listo para presentar a la Municipalidad Provincial de Arequipa.
    </p>

    @include('partials.errores')

    <!-- Selector de mes: el PDF se genera solo con los registros del mes elegido -->
    <form action="{{ route('reportes.pdf') }}" method="GET" style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
        <div>
            <label for="mes" style="color: #cbd5e1; display: block; margin-bottom: 0.4rem;">Mes a rendir:</label>
            <input type="month" id="mes" name="mes" value="{{ now()->format('Y-m') }}" max="{{ now()->format('Y-m') }}"
                   pattern="[0-9]{4}-[0-9]{2}" placeholder="AAAA-MM"
                   style="background-color: #0f1422; border: 1px solid rgba(255,255,255,0.08); color: #ffffff; border-radius: 8px; padding: 0.7rem 1rem; font-size: 0.95rem;">
        </div>
        <button type="submit" class="btn-premium" style="width: auto;">
            <i class="fa-solid fa-file-pdf"></i> Descargar informe PDF
        </button>
    </form>

    <a href="{{ route('dashboard') }}" class="btn-premium secondary" style="width: auto; margin-top: 1rem;">
        <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
    </a>
</div>
@endsection