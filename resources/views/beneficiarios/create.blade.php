@extends('layouts.app')

@section('title', 'Nuevo Beneficiario')

@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white; margin-bottom: 1.5rem;">Registrar Nuevo Comensal</h2>
    
    <form action="{{ route('beneficiarios.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Código Anonimizado:</label>
            <input type="text" name="codigo_beneficiario" class="input-asistencia-premium" required placeholder="Ej: BEN-CHA-100">
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Tipo de Comensal:</label>
            <select name="tipo_comensal" class="input-asistencia-premium">
                <option value="Socio/Cocinera">Socio/Cocinera</option>
                <option value="Público General">Público General</option>
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Integrantes de la familia:</label>
            <input type="number" name="cantidad_integrantes" class="input-asistencia-premium" min="1" value="1" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Raciones asignadas (máx 4):</label>
            <input type="number" name="raciones_asignadas" class="input-asistencia-premium" min="1" max="4" value="1" required>
        </div>

        <button type="submit" class="btn-premium" style="width: 100%;">Guardar Beneficiario</button>
        <a href="{{ route('beneficiarios.index') }}" class="btn-premium secondary" style="width: 100%; margin-top: 0.5rem; text-align: center;">Cancelar</a>
    </form>
</div>
@endsection