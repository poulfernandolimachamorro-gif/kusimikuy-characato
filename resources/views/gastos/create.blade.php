@extends('layouts.app')

@section('title', 'Nuevo Gasto')

@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white; margin-bottom: 1.5rem;">Registrar Gasto</h2>
    
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gastos.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Concepto del Gasto:</label>
            <input type="text" name="concepto" class="input-asistencia-premium" required placeholder="Ej: Compra de papas y carne">
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Monto (S/.):</label>
            <input type="number" step="0.01" name="monto" class="input-asistencia-premium" required placeholder="50.00">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Fecha del Gasto:</label>
            <input type="date" name="fecha_gasto" class="input-asistencia-premium" required value="{{ date('Y-m-d') }}">
        </div>

        <button type="submit" class="btn-premium" style="width: 100%;">Guardar Gasto</button>
        <a href="{{ route('gastos.index') }}" class="btn-premium secondary" style="width: 100%; margin-top: 0.5rem; text-align: center;">Cancelar</a>
    </form>
</div>
@endsection