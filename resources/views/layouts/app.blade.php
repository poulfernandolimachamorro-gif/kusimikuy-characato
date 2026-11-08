<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KusiMikuy - @yield('title', 'Dashboard')</title>

    <!-- Estilos base (para que Tailwind de Breeze no los pise) -->
    <style>
        html, body {
            background-color: #070a12 !important;
            color: #f1f5f9 !important;
            margin: 0; padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif !important;
            font-size: 14px !important; /* Tamaño fijo en 14px */
            min-height: 100vh;
            overflow-x: hidden !important;
            background-image: radial-gradient(at 0% 0%, rgba(26, 117, 255, 0.1) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(34, 197, 94, 0.08) 0px, transparent 50%) !important;
        }
        
        h1, h2, h3, h4, h5, h6 { font-size: revert !important; font-weight: bold; }
        
        .ancho-controlado { max-width: 1240px; margin: 0 auto; padding: 0 1.25rem; width: 100%; box-sizing: border-box; }
        
        .menu-superior {
            background: rgba(13, 18, 30, 0.5);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            padding: 0.85rem 0;
            margin-bottom: 2.5rem;
        }

        /* Botones */
        .btn-premium {
            background: linear-gradient(135deg, #1a75ff, #0052cc) !important;
            color: white !important;
            border-radius: 10px !important;
            padding: 1rem 1.5rem;
            font-weight: 700;
            text-decoration: none !important;
            display: inline-flex; align-items: center; justify-content: center; gap: 0.7rem;
            min-height: 54px; transition: all 0.3s ease;
            border: none !important;
            box-sizing: border-box !important; /* el padding no agranda el botón */
            min-width: 0 !important; /* evita que el botón se desborde */
        }
        .btn-premium.secondary {
            background: rgba(30, 41, 59, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
            box-shadow: none;
        }
        
        .text-exito { color: #4ade80 !important; }
        .subtexto { color: #94a3b8; font-size: 0.9rem; }
    </style>
    
    <!-- Íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Menú superior -->
    <nav class="menu-superior">
        <div class="ancho-controlado" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
            <strong style="font-size: 1.2rem; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-bowl-rice text-exito"></i> 
                KusiMikuy <span style="color: #1a75ff; font-weight: 300; display: none;">Characato</span> <!-- Se oculta para ganar espacio en el celular -->
            </strong>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <a href="{{ route('dashboard') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.8rem;"><i class="fa-solid fa-house"></i> Inicio</a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido de cada página -->
    <main class="ancho-controlado">
        @yield('content')
    </main>

    <!-- Pie de página -->
    <footer style="margin-top: 5rem; padding: 2rem 0; border-top: 1px solid rgba(255, 255, 255, 0.04); background: rgba(9, 13, 22, 0.5);">
        <div class="ancho-controlado" style="text-align: center;">
            <p class="subtexto" style="margin: 0; font-size: 0.8rem; line-height: 1.5rem;">
                <strong>KusiMikuy Enterprise v3.9</strong> — Sistema de Impacto Social para el Comedor "Niño Jesús".<br>
                Módulos visuales adaptados a la infraestructura técnica de la Universidad Continental.
            </p>
        </div>
    </footer>
</body>
</html>