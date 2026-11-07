@extends('layouts.app')

@section('title', 'Nuevo Beneficiario')

@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto;">
    <h2 style="color: white;">Registrar Nuevo Comensal</h2>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
            <strong>¡Ups! Hubo un problema:</strong>
            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('beneficiarios.store') }}" method="POST">
        @csrf
        <label style="color: #cbd5e1;">Código Anonimizado:</label>
        <input type="text" name="codigo_beneficiario" class="input-asistencia-premium" required placeholder="Ej: BEN-CHA-005">
        
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Tipo de Comensal:</label>
        <select name="tipo_comensal" class="input-asistencia-premium">
            <option value="Socio/Cocinera">Socio/Cocinera</option>
            <option value="Público General">Público General</option>
        </select>

        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Integrantes de la familia:</label>
        <input type="number" name="cantidad_integrantes" class="input-asistencia-premium" min="1" value="1">

        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Raciones asignadas (máx 4):</label>
        <input type="number" name="raciones_asignadas" class="input-asistencia-premium" min="1" max="4" value="1">

        <button type="submit" class="btn-premium" style="margin-top: 1.5rem;">Guardar Beneficiario</button>
        <a href="{{ route('beneficiarios.index') }}" class="btn-premium secondary" style="margin-top: 0.5rem;">Cancelar</a>
    </form>
</div>
@endsection