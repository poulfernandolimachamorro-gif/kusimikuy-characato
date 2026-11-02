@extends('layouts.app')

@section('title', 'Reportes MPA')

@section('content')
<div class="caja-cristal" style="padding: 3rem; text-align: center; max-width: 800px; margin: 0 auto;">
    <i class="fa-solid fa-file-pdf" style="font-size: 4rem; color: #f87171; margin-bottom: 1rem;"></i>
    <h2 style="color: white; margin-bottom: 1rem;">Exportación de Informe Mensual MPA</h2>
    <p class="subtexto" style="max-width: 600px; margin: 0 auto 2rem auto;">
        Módulo de compilación analítica contable para la fiscalización de la Municipalidad Provincial de Arequipa.
    </p>
    
    <!-- Botón para descargar el PDF Real -->
    <a href="{{ route('reportes.pdf') }}" class="btn-premium" style="max-width: 350px; margin: 0 auto 1.5rem auto; display: block;">
        <i class="fa-solid fa-file-pdf"></i> Descargar Reporte PDF Real
    </a>

    <!-- Botón para volver -->
    <a href="{{ route('dashboard') }}" class="btn-premium secondary" style="max-width: 250px; margin: 0 auto; display: block;">
        <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
    </a>
</div>
@endsection