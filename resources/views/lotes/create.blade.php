@extends('layouts.app')
@section('title', 'Nuevo Lote')
@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white;">Registrar Lote</h2>
    <form action="{{ route('lotes.store') }}" method="POST">
        @csrf
        <label style="color: #cbd5e1;">Insumo:</label>
        <select name="insumo_id" class="input-asistencia-premium">
            @foreach($insumos as $insumo) <option value="{{ $insumo->id }}">{{ $insumo->nombre_insumo }}</option> @endforeach
        </select>
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Código Lote:</label>
        <input type="text" name="codigo_lote" class="input-asistencia-premium" required>
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Fecha Vencimiento:</label>
        <input type="date" name="fecha_vencimiento" class="input-asistencia-premium">
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Estado Calidad:</label>
        <select name="estado_calidad" class="input-asistencia-premium">
            <option value="Óptimo">Óptimo</option>
            <option value="Defectuoso/Verde">Defectuoso/Verde</option>
            <option value="Mermado">Mermado</option>
        </select>
        <button type="submit" class="btn-premium" style="margin-top: 1.5rem;">Guardar</button>
    </form>
</div>
@endsection