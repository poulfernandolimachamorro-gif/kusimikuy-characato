@extends('layouts.app')

@section('title', 'Padrón de Beneficiarios')

@section('content')
<div class="animacion-entrada">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: white; font-weight: 800; margin: 0;">
            <i class="fa-solid fa-users text-exito"></i> Padrón Oficial de Comensales
        </h2>
        <a href="{{ route('dashboard') }}" class="btn-premium secondary" style="width: auto; min-height: 40px; padding: 0 1rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="caja-cristal">
        <table style="width: 100%; border-collapse: collapse; color: #cbd5e1;">
            <thead>
                <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left;">
                    <th style="padding: 1rem;">Código Anonimizado</th>
                    <th style="padding: 1rem;">Tipo de Comensal</th>
                    <th style="padding: 1rem;">Integrantes</th>
                    <th style="padding: 1rem;">Raciones</th>
                    <th style="padding: 1rem;">Estado</th>
                    <th style="padding: 1rem;">Acciones</th> <!-- NUEVA COLUMNA -->
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiarios as $beneficiario)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 1rem; font-weight: bold; color: #66b2ff;">{{ $beneficiario->codigo_beneficiario }}</td>
                    <td style="padding: 1rem;">{{ $beneficiario->tipo_comensal }}</td>
                    <td style="padding: 1rem;">{{ $beneficiario->cantidad_integrantes }} personas</td>
                    <td style="padding: 1rem;">{{ $beneficiario->raciones_asignadas }} platos</td>
                    <td style="padding: 1rem;">
                        <span style="background: rgba(34, 197, 94, 0.1); color: #4ade80; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                            Activo
                        </span>
                    </td>
                    <!-- NUEVA CELDA DE ACCIONES -->
                    <td style="padding: 1rem; display: flex; gap: 0.5rem;">
                        <!-- Botón Editar (Visual) -->
                        <button onclick="alert('Formulario de edición en integración.')" class="btn-premium secondary" style="padding: 0.2rem 0.5rem; min-height: 30px; width: auto;">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <!-- Botón Eliminar (Baja lógica funcional) -->
                        <form action="{{ route('beneficiarios.destroy', $beneficiario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-premium" style="background: #ef4444 !important; padding: 0.2rem 0.5rem; min-height: 30px; width: auto;" onclick="return confirm('¿Dar de baja lógica a este beneficiario?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection