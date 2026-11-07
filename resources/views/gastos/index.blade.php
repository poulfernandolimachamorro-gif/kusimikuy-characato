@extends('layouts.app')
@section('title', 'Gastos')
@section('content')
<div class="caja-cristal" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
        <h2 style="color: white;">Registro de Gastos</h2>
        <a href="{{ route('gastos.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Gasto</a>
    </div>
    @if(session('success')) <div class="alerta-exito">{{ session('success') }}</div> @endif
    <table style="width: 100%; color: #cbd5e1;">
        <thead><tr style="border-bottom: 1px solid #333;"><th>Concepto</th><th>Monto</th><th>Fecha</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($gastos as $gasto)
            <tr style="border-bottom: 1px solid #222;">
                <td>{{ $gasto->concepto }}</td>
                <td>S/. {{ number_format($gasto->monto, 2) }}</td>
                <td>{{ $gasto->fecha_gasto }}</td>
                <td>
                    <form action="{{ route('gastos.destroy', $gasto->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-premium" style="background:#ef4444; width:auto; min-height:30px; padding:0 0.5rem;" onclick="return confirm('¿Eliminar?')"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection