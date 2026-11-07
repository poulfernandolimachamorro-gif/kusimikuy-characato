@extends('layouts.app')

@section('title', 'Gastos')

@section('content')
<div class="caja-cristal" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; align-items: center;">
        <h2 style="color: white; margin: 0;">Registro de Gastos</h2>
        <a href="{{ route('gastos.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Gasto</a>
    </div>
    
    @if(session('success'))
        <div class="alerta-exito" style="background: rgba(34, 197, 94, 0.1); border-left: 4px solid #22c55e; color: #86efac; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; color: #cbd5e1;">
        <thead>
            <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left;">
                <th style="padding: 1rem;">Concepto</th>
                <th style="padding: 1rem;">Monto</th>
                <th style="padding: 1rem;">Fecha</th>
                <th style="padding: 1rem;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gastos as $gasto)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 1rem;">{{ $gasto->concepto }}</td>
                <td style="padding: 1rem; font-weight: bold; color: #f87171;">S/. {{ number_format($gasto->monto, 2) }}</td>
                <td style="padding: 1rem;">{{ $gasto->fecha_gasto }}</td>
                <td style="padding: 1rem;">
                    <form action="{{ route('gastos.destroy', $gasto->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn-premium" style="background:#ef4444; width:auto; min-height:30px; padding:0 0.5rem;" onclick="return confirm('¿Eliminar este gasto?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($gastos->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center; padding: 2rem; color: #94a3b8;">No hay gastos registrados.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection