@extends('layouts.app')
@section('title', 'Documentos')
@section('content')
<div class="caja-cristal" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
        <h2 style="color: white;">Documentos Legales</h2>
        <a href="{{ route('documentos.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Documento</a>
    </div>
    @if(session('success')) <div class="alerta-exito">{{ session('success') }}</div> @endif
    @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; color: #fca5a5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
        </div>
    @endif
    <table style="width: 100%; color: #cbd5e1;">
        <thead><tr style="border-bottom: 1px solid #333;"><th>Tipo</th><th>Emisión</th><th>Caducidad</th><th>Vigencia</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($documentos as $doc)
            <tr style="border-bottom: 1px solid #222;">
                <td>{{ $doc->tipo_documento }}</td>
                <td>{{ $doc->fecha_emision }}</td>
                <td>{{ $doc->fecha_caducidad }}</td>
                <td>
                    <span style="color: {{ $doc->color_vigencia }}; font-weight: 700;">{{ $doc->estado_vigencia }}</span>
                    <span style="font-size: 0.8rem; color: #94a3b8;">
                        @if($doc->dias_restantes >= 0) ({{ $doc->dias_restantes }} días) @else (hace {{ abs($doc->dias_restantes) }} días) @endif
                    </span>
                </td>
                <td>
                    <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="btn-premium" style="background:#ef4444; width:auto; min-height:30px; padding:0 0.5rem;" onclick="return confirm('¿Eliminar?')"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
