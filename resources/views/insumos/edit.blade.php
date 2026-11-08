@extends('layouts.app')
@section('title', 'Editar Insumo')
@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white; margin-bottom: 1.5rem;">Modificar Parámetros de Insumo</h2>
    <form action="{{ route('insumos.update', $insumo->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Nombre del Insumo:</label>
            <input type="text" name="nombre_insumo" class="input-asistencia-premium" value="{{ $insumo->nombre_insumo }}" required>
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-top: 1rem; margin-bottom: 0.5rem;">Masa/Volumen Físico Actual:</label>
            <input type="number" step="0.01" name="stock_actual" class="input-asistencia-premium" value="{{ $insumo->stock_actual }}" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="color: #cbd5e1; display: block; margin-top: 1rem; margin-bottom: 0.5rem;">Unidad Estandarizada:</label>
            <select name="unidad_medida" class="input-asistencia-premium">
                <option value="Kilogramos" {{ $insumo->unidad_medida == 'Kilogramos' ? 'selected' : '' }}>Kilogramos</option>
                <option value="Litros" {{ $insumo->unidad_medida == 'Litros' ? 'selected' : '' }}>Litros</option>
                <option value="Unidades" {{ $insumo->unidad_medida == 'Unidades' ? 'selected' : '' }}>Unidades</option>
                <option value="Sacos" {{ $insumo->unidad_medida == 'Sacos' ? 'selected' : '' }}>Sacos</option>
            </select>
        </div>
        <button type="submit" class="btn-premium" style="width: 100%;">Actualizar Existencias</button>
    </form>
</div>
@endsection