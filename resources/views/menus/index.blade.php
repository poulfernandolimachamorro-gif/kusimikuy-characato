@extends('layouts.app')
@section('title', 'Recetas')
@section('content')
<div class="caja-cristal" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
        <h2 style="color: white;">Menús y Recetas</h2>
        <a href="{{ route('menus.create') }}" class="btn-premium" style="width: auto;">+ Nueva Receta</a>
    </div>
    @if(session('success')) <div class="alerta-exito">{{ session('success') }}</div> @endif
    <table style="width: 100%; color: #cbd5e1;">
        <thead><tr style="border-bottom: 1px solid #333;"><th>Plato</th><th>Insumo ID</th><th>Gramos/Ración</th><th>Acciones</th></tr></thead>
        <tbody>
            @foreach($menus as $menu)
            <tr style="border-bottom: 1px solid #222;">
                <td>{{ $menu->nombre_plato }}</td>
                <td>{{ $menu->insumo_id }}</td>
                <td>{{ $menu->gramos_por_racion }} g</td>
                <td>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="btn-premium" style="background:#ef4444; width:auto; min-height:30px; padding:0 0.5rem;" onclick="return confirm('¿Eliminar?')"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection