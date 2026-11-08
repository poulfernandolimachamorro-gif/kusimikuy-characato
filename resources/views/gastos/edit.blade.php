@extends('layouts.app')

@section('title', 'Editar Gasto')

@section('content')
<div class="caja-cristal" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    <h2 style="color: white; margin-bottom: 1.5rem;">Editar Gasto</h2>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gastos.update', $gasto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Concepto del Gasto:</label>
            <input type="text" name="concepto" class="input-asistencia-premium" value="{{ old('concepto', $gasto->concepto) }}" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Monto (S/.):</label>
            <input type="number" step="0.01" name="monto" class="input-asistencia-premium" value="{{ old('monto', $gasto->monto) }}" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Fecha del Gasto:</label>
            <input type="date" name="fecha_gasto" class="input-asistencia-premium" value="{{ old('fecha_gasto', substr($gasto->fecha_gasto, 0, 10)) }}" required>
        </div>

        <button type="submit" class="btn-premium" style="width: 100%;">Actualizar Gasto</button>
        <a href="{{ route('gastos.index') }}" class="btn-premium secondary" style="width: 100%; margin-top: 0.5rem; text-align: center;">Cancelar</a>
    </form>
</div>
@endsection
