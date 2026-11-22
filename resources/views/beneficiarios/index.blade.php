@extends('layouts.app')

@section('title', 'Padrón de Beneficiarios')

@section('content')
<div class="animacion-entrada">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: white; font-weight: 800; margin: 0;">
            <i class="fa-solid fa-users text-exito"></i> Padrón Oficial de Comensales
        </h2>
        <a href="{{ route('dashboard') }}" class="btn-premium secondary" style="width: auto; min-height: 40px; padding: 0 1rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito" style="background: rgba(34, 197, 94, 0.1); border-left: 4px solid #22c55e; color: #86efac; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @include('partials.errores')

    <div class="caja-cristal">
        <div style="margin-bottom: 1rem;">
            <a href="{{ route('beneficiarios.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Beneficiario</a>
        </div>

        <!-- Contenedor con desplazamiento horizontal: en el celular la tabla se desliza con el dedo -->
        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table style="width: 100%; min-width: 640px; border-collapse: collapse; color: #cbd5e1;">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left;">
                        <th style="padding: 1rem;">Código Anonimizado</th>
                        <th style="padding: 1rem;">Tipo de Comensal</th>
                        <th style="padding: 1rem;">Integrantes</th>
                        <th style="padding: 1rem;">Raciones</th>
                        <th style="padding: 1rem;">Estado</th>
                        <th style="padding: 1rem;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beneficiarios as $beneficiario)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 1rem; font-weight: bold; color: #66b2ff; white-space: nowrap;">{{ $beneficiario->codigo_beneficiario }}</td>
                        <td style="padding: 1rem; white-space: nowrap;">{{ $beneficiario->tipo_comensal }}</td>
                        <td style="padding: 1rem; white-space: nowrap;">{{ $beneficiario->cantidad_integrantes }} personas</td>
                        <td style="padding: 1rem; white-space: nowrap;">{{ $beneficiario->raciones_asignadas }} platos</td>
                        <td style="padding: 1rem;">
                            <span style="background: rgba(34, 197, 94, 0.1); color: #4ade80; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                                Activo
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <!-- Botón Editar -->
                                <a href="{{ route('beneficiarios.edit', $beneficiario->id) }}" class="btn-premium secondary" style="padding: 0.2rem 0.5rem; min-height: 30px; width: auto;">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <!-- Botón Eliminar (baja lógica) -->
                                <form action="{{ route('beneficiarios.destroy', $beneficiario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-premium" style="background: #ef4444 !important; padding: 0.2rem 0.5rem; min-height: 30px; width: auto;" onclick="return confirm('¿Dar de baja lógica a este beneficiario?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación: anterior, números de página y siguiente (sin escribir ?page=2 en la URL) -->
        @if($beneficiarios->hasPages())
        <nav aria-label="Paginación del padrón" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.25rem;">
            <span style="color: #94a3b8; font-size: 0.85rem;">
                Mostrando {{ $beneficiarios->firstItem() }}–{{ $beneficiarios->lastItem() }} de {{ $beneficiarios->total() }} familias
            </span>

            <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                @if($beneficiarios->onFirstPage())
                    <span class="btn-premium secondary" style="width: auto; min-height: 36px; padding: 0 0.8rem; opacity: 0.4; cursor: not-allowed;">
                        <i class="fa-solid fa-chevron-left"></i> Anterior
                    </span>
                @else
                    <a href="{{ $beneficiarios->previousPageUrl() }}" class="btn-premium secondary" style="width: auto; min-height: 36px; padding: 0 0.8rem;">
                        <i class="fa-solid fa-chevron-left"></i> Anterior
                    </a>
                @endif

                @foreach($beneficiarios->getUrlRange(1, $beneficiarios->lastPage()) as $pagina => $url)
                    @if($pagina === $beneficiarios->currentPage())
                        <span class="btn-premium" aria-current="page" style="width: auto; min-height: 36px; padding: 0 0.9rem;">{{ $pagina }}</span>
                    @else
                        <a href="{{ $url }}" class="btn-premium secondary" style="width: auto; min-height: 36px; padding: 0 0.9rem;">{{ $pagina }}</a>
                    @endif
                @endforeach

                @if($beneficiarios->hasMorePages())
                    <a href="{{ $beneficiarios->nextPageUrl() }}" class="btn-premium secondary" style="width: auto; min-height: 36px; padding: 0 0.8rem;">
                        Siguiente <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="btn-premium secondary" style="width: auto; min-height: 36px; padding: 0 0.8rem; opacity: 0.4; cursor: not-allowed;">
                        Siguiente <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </nav>
        @endif
    </div>
</div>
@endsection