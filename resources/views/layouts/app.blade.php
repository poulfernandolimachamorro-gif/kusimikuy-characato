<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KusiMikuy - @yield('title', 'Dashboard')</title>

    <!-- Scripts de Vite (Necesario para que funcione Breeze) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Crítico -->
    <style>
        html, body {
            background-color: #070a12 !important;
            color: #f1f5f9 !important;
            margin: 0; padding: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }
        .ancho-controlado { max-width: 1240px; margin: 0 auto; padding: 0 1.25rem; width: 100%; }
        .menu-superior {
            background: rgba(13, 18, 30, 0.5);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            padding: 0.85rem 0;
            margin-bottom: 2.5rem;
        }
        .btn-premium { background: linear-gradient(135deg, #1a75ff, #0052cc) !important; color: white !important; border-radius: 10px !important; padding: 1rem 1.5rem; font-weight: 700; text-decoration: none !important; display: inline-flex; align-items: center; justify-content: center; gap: 0.7rem; }
        .caja-cristal { background: rgba(18, 24, 38, 0.65) !important; backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.05) !important; border-radius: 14px !important; padding: 1.75rem; }
        .text-exito { color: #4ade80 !important; }
        .subtexto { color: #94a3b8; font-size: 0.9rem; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Barra de Navegación -->
    <nav class="menu-superior">
        <div class="ancho-controlado" style="display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 1.35rem; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-bowl-rice text-exito"></i> 
                KusiMikuy <span style="color: #1a75ff; font-weight: 300;">Characato</span>
            </strong>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="{{ route('dashboard') }}" style="color: #cbd5e1; text-decoration: none;"><i class="fa-solid fa-house"></i> Inicio</a>
                <!-- Botón de Logout -->
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.8rem; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="ancho-controlado">
        <!-- {{ $slot ?? '' }} <--- BORRA O COMENTA ESTA LÍNEA -->
        @yield('content')
    </main>
</body>
</html>