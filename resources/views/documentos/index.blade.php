@extends('layouts.app')
@section('title', 'Documentos')
@section('content')
<div class="caja-cristal" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
        <h2 style="color: white;">Documentos Legales</h2>
        <a href="{{ route('documentos.create') }}" class="btn-premium" style="width: auto;">+ Nuevo Documento</a>
    </div>
    @if(session('success')) <div class="alerta-exito">{{ session('success') }}</div> @endif
    <table style="width: 100%; color: #cbd5e1;">
        <thead><tr style="border-bottom: 1px solid #333;"><th>Tipo</th><th>Emisión</th><th>Caducidad</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($documentos as $doc)
            <tr style="border-bottom: 1px solid #222;">
                <td>{{ $doc->tipo_documento }}</td>
                <td>{{ $doc->fecha_emision }}</td>
                <td>{{ $doc->fecha_caducidad }}</td>
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