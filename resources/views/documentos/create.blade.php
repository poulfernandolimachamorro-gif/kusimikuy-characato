@extends('layouts.app')
@section('title', 'Nuevo Documento')
@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white;">Registrar Documento</h2>
    <form action="{{ route('documentos.store') }}" method="POST">
        @csrf
        <label style="color: #cbd5e1;">Tipo de Documento:</label>
        <select name="tipo_documento" class="input-asistencia-premium">
            <option value="Resolución Municipal">Resolución Municipal</option>
            <option value="Registros Públicos">Registros Públicos</option>
            <option value="Libro de Actas Mensual">Libro de Actas Mensual</option>
        </select>
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Fecha Emisión:</label>
        <input type="date" name="fecha_emision" class="input-asistencia-premium" required>
        <label style="color: #cbd5e1; margin-top: 1rem; display: block;">Fecha Caducidad:</label>
        <input type="date" name="fecha_caducidad" class="input-asistencia-premium" required>
        <button type="submit" class="btn-premium" style="margin-top: 1.5rem;">Guardar</button>
    </form>
</div>
@endsection