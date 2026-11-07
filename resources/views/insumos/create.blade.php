@extends('layouts.app')
@section('title', 'Nuevo Insumo')
@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto;">
    <h2 style="color: white;">Registrar Insumo</h2>
    <form action="{{ route('insumos.store') }}" method="POST">
        @csrf
        <label style="color: #cbd5e1;">Nombre del Insumo:</label>
        <input type="text" name="nombre_insumo" class="input-asistencia-premium" required>
        
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Stock Inicial:</label>
        <input type="number" step="0.01" name="stock_actual" class="input-asistencia-premium" required>

        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Unidad de Medida:</label>
        <select name="unidad_medida" class="input-asistencia-premium">
            <option value="Kilogramos">Kilogramos</option>
            <option value="Litros">Litros</option>
            <option value="Unidades">Unidades</option>
            <option value="Sacos">Sacos</option>
        </select>
        <button type="submit" class="btn-premium" style="margin-top: 1.5rem;">Guardar Insumo</button>
    </form>
</div>
@endsection