@extends('layouts.app')

@section('title', 'Control de Almacén')

@section('content')
<style>
    .tabla-kardex {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    .tabla-kardex th {
        text-align: left;
        padding: 1rem;
        color: #94a3b8;
        font-size: 0.85rem;
        text-transform: uppercase;
        border-bottom: 2px solid rgba(255,255,255,0.05);
    }
    .tabla-kardex td {
        padding: 1rem;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255,255,255,0.02);
    }
    .badge-stock {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    .stock-ok { background: rgba(34, 197, 94, 0.1); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.2); }
    .stock-bajo { background: rgba(234, 179, 8, 0.1); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.2); }
    .stock-critico { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
</style>

<div class="caja-cristal" style="padding: 2.5rem; animation: moduloSlideIn 0.4s ease-out;">
    
    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
        <div>
            <h2 style="color: white; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-warehouse" style="color: #3b82f6;"></i> Control de Almacén e Inventarios
            </h2>
            <p class="subtexto" style="margin: 0.5rem 0 0 0;">Monitoreo inmutable del Kardex de suministros y mermas físicas (RF-04).</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn-premium secondary" style="width: auto; padding: 0 1rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Tabla de Insumos -->
    <table class="tabla-kardex">
        <thead>
            <tr>
                <th>Insumo Base</th>
                <th>Unidad de Medida</th>
                <th>Stock Actual</th>
                <th>Límite Diario MPA</th>
                <th>Estado (Semáforo)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($insumos as $insumo)
            <tr>
                <td style="font-weight: bold; color: #ffffff;">
                    <i class="fa-solid fa-box" style="color: #64748b; margin-right: 0.5rem;"></i>
                    {{ $insumo->nombre_insumo }}
                </td>
                <td>{{ $insumo->unidad_medida }}</td>
                <td style="font-weight: bold; font-size: 1.1rem;">
                    {{ number_format($insumo->stock_actual, 2) }}
                </td>
                <td>
                    @if($insumo->limite_consumo_diario)
                        <span style="color: #f87171;">{{ number_format($insumo->limite_consumo_diario, 2) }} kg</span>
                    @else
                        <span class="subtexto">N/A</span>
                    @endif
                </td>
                <td>
                    @if($insumo->stock_actual <= 0)
                        <span class="badge-stock stock-critico"><i class="fa-solid fa-circle-xmark"></i> Agotado</span>
                    @elseif($insumo->stock_actual <= $insumo->stock_minimo_alerta)
                        <span class="badge-stock stock-bajo"><i class="fa-solid fa-triangle-exclamation"></i> Stock Bajo</span>
                    @else
                        <span class="badge-stock stock-ok"><i class="fa-solid fa-circle-check"></i> Suficiente</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 3rem; color: #94a3b8;">
                    <i class="fa-solid fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; color: #334155;"></i>
                    <p>No hay insumos registrados en el almacén.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection