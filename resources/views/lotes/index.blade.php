@extends('layouts.app')
@section('title', 'Lotes')
@section('content')
<div class="caja-cristal" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
        <h2 style="color: white;">Gestión de Lotes</h2>
        <a href="{{ route('lotes.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Lote</a>
    </div>
    @if(session('success')) <div class="alerta-exito">{{ session('success') }}</div> @endif
    <table style="width: 100%; color: #cbd5e1;">
        <thead><tr style="border-bottom: 1px solid #333;"><th>Lote</th><th>Vencimiento</th><th>Calidad</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($lotes as $lote)
            <tr style="border-bottom: 1px solid #222;">
                <td>{{ $lote->codigo_lote }}</td>
                <td>{{ $lote->fecha_vencimiento }}</td>
                <td><span class="badge-stock {{ $lote->estado_calidad == 'Óptimo' ? 'stock-ok' : ($lote->estado_calidad == 'Mermado' ? 'stock-critico' : 'stock-bajo') }}">{{ $lote->estado_calidad }}</span></td>
                <td>
                    <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="btn-premium" style="background:#ef4444; width:auto; min-height:30px; padding:0 0.5rem;" onclick="return confirm('¿Eliminar?')"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection