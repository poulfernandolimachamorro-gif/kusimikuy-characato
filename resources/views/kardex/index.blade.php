@extends('layouts.app')

@section('title', 'Control de Almacén')

@section('content')
<div class="caja-cristal" style="padding: 3rem; text-align: center; max-width: 800px; margin: 0 auto;">
    <i class="fa-solid fa-warehouse" style="font-size: 4rem; color: #3b82f6; margin-bottom: 1rem;"></i>
    <h2 style="color: white; margin-bottom: 1rem;">Control de Almacén e Inventarios</h2>
    <p class="subtexto" style="max-width: 600px; margin: 0 auto 2rem auto;">
        Este módulo permitirá mapear de forma inmutable los movimientos de stock (entradas de la MPA y salidas de cocina).
    </p>
    <a href="{{ route('dashboard') }}" class="btn-premium" style="max-width: 250px; margin: 0 auto;">
        <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
    </a>
</div>
@endsection