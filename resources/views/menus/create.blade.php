@extends('layouts.app')
@section('title', 'Nueva Receta')
@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white;">Registrar Receta</h2>
    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <label style="color: #cbd5e1;">Nombre del Plato:</label>
        <input type="text" name="nombre_plato" class="input-asistencia-premium" required>
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Insumo:</label>
        <select name="insumo_id" class="input-asistencia-premium">
            @foreach($insumos as $insumo) <option value="{{ $insumo->id }}">{{ $insumo->nombre_insumo }}</option> @endforeach
        </select>
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Gramos por Ración:</label>
        <input type="number" step="0.01" name="gramos_por_racion" class="input-asistencia-premium" required>
        <button type="submit" class="btn-premium" style="margin-top: 1.5rem;">Guardar</button>
    </form>
</div>
@endsection