@extends('layouts.app')
@section('title', 'Insumos')
@section('content')
<div class="caja-cristal">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: white;">Gestión de Insumos</h2>
        <a href="{{ route('insumos.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Insumo</a>
    </div>
    @if(session('success')) <div class="alerta-exito">{{ session('success') }}</div> @endif
    <table style="width: 100%; border-collapse: collapse; color: #cbd5e1;">
        <thead>
            <tr style="border-bottom: 2px solid rgba(255,255,255,0.1);">
                <th style="padding: 1rem;">Insumo</th>
                <th style="padding: 1rem;">Stock Actual</th>
                <th style="padding: 1rem;">Unidad</th>
                <th style="padding: 1rem;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($insumos as $insumo)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 1rem;">{{ $insumo->nombre_insumo }}</td>
                <td style="padding: 1rem;">{{ $insumo->stock_actual }}</td>
                <td style="padding: 1rem;">{{ $insumo->unidad_medida }}</td>
                <td style="padding: 1rem;">
                    <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-premium" style="background: #ef4444; padding: 0.2rem 0.5rem; min-height: 30px; width: auto;" onclick="return confirm('¿Eliminar?')"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection