@extends('layouts.app')

@section('title', 'Editar Beneficiario')

@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white; margin-bottom: 1.5rem;">Editar Comensal: {{ $beneficiario->codigo_beneficiario }}</h2>
    
    <form action="{{ route('beneficiarios.update', $beneficiario->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Código Anonimizado:</label>
            <input type="text" name="codigo_beneficiario" class="input-asistencia-premium" value="{{ $beneficiario->codigo_beneficiario }}" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Tipo de Comensal:</label>
            <select name="tipo_comensal" class="input-asistencia-premium">
                <option value="Socio/Cocinera" {{ $beneficiario->tipo_comensal == 'Socio/Cocinera' ? 'selected' : '' }}>Socio/Cocinera</option>
                <option value="Público General" {{ $beneficiario->tipo_comensal == 'Público General' ? 'selected' : '' }}>Público General</option>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Raciones asignadas (máx 4):</label>
            <input type="number" name="raciones_asignadas" class="input-asistencia-premium" min="1" max="4" value="{{ $beneficiario->raciones_asignadas }}" required>
        </div>

        <button type="submit" class="btn-premium" style="width: 100%;">Actualizar Beneficiario</button>
        <a href="{{ route('beneficiarios.index') }}" class="btn-premium secondary" style="width: 100%; margin-top: 0.5rem; text-align: center;">Cancelar</a>
    </form>
</div>
@endsection
