<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KusiMikuy Characato - @yield('title')</title>
    
    <!-- Bloque de Estilos Críticos Prioritarios: Evita el parpadeo en blanco (FOUC) al renderizar instantáneamente el fondo oscuro -->
    <style>
        html, body {
            background-color: #090d16 !important;
            color: #f1f5f9 !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>

    <!-- Framework Estructural Ligero (Alineado al RNF-01 del Informe de menos de 1.5MB) -->
    <link rel="stylesheet" href="https://jsdelivr.net" media="screen">
    <!-- Iconografía Semántica Avanzada FontAwesome v6 -->
    <link rel="stylesheet" href="https://cloudflare.com" media="screen">
    
    <style>
        body {
            background-image: radial-gradient(at 0% 0%, rgba(26, 117, 255, 0.09) 0px, transparent 45%),
                              radial-gradient(at 100% 100%, rgba(34, 197, 94, 0.07) 0px, transparent 45%) !important;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Contenedor de Ancho Máximo Controlado para Evitar Estiramientos en Monitores PC */
        .contenedor-maestro {
            max-width: 1260px;
            margin: 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        /* Glassmorphism de Alta Fidelidad con Bordes de Neón Opaco Traducidos */
        .card-moderna {
            background: rgba(17, 24, 39, 0.75) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-radius: 16px !important;
            padding: 2.25rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.6);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-moderna:hover {
            border-color: rgba(26, 117, 255, 0.4) !important;
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -5px rgba(26, 117, 255, 0.15);
        }

        /* Botones Premium con Micro-Interacciones de Escala para Evitar Pulsaciones Erróneas */
        .btn-premium {
            background: linear-gradient(135deg, #1a75ff, #0052cc) !important;
            border: none !important;
            color: #ffffff !important;
            padding: 1.25rem 2rem;
            font-weight: 700;
            border-radius: 12px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            min-height: 54px; /* Cumple Criterio de Éxito WCAG 2.2 SC 2.5.8 */
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 20px rgba(26, 117, 255, 0.25);
        }
        .btn-premium:hover {
            filter: brightness(1.2);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 30px rgba(26, 117, 255, 0.4);
        }

        /* Variación Secundaria para Menús Logísticos Inferiores */
        .btn-premium.secondary {
            background: rgba(30, 41, 59, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
            box-shadow: none;
        }
        .btn-premium.secondary:hover {
            background: rgba(51, 65, 85, 0.8) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        /* Barra de Navegación Fija */
        nav.nav-top {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem 0;
            margin-bottom: 3rem;
        }

        .text-exito { color: #4ade80 !important; }
        .text-alerta { color: #facc15 !important; }
        .text-peligro { color: #f87171 !important; }
        .subtexto { color: #94a3b8; font-size: 0.95rem; }
    </style>
</head>
<body>
    <!-- Encabezado Corporativo de la Plataforma -->
    <nav class="nav-top">
        <div class="contenedor-maestro" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <strong style="font-size: 1.45rem; color: #ffffff; display: flex; align-items: center; gap: 0.6rem; letter-spacing: -0.02em;">
                <i class="fa-solid fa-bowl-rice text-exito" style="filter: drop-shadow(0 0 10px #22c55e);"></i> 
                KusiMikuy <span style="color: #1a75ff; font-weight: 300;">Characato</span>
            </strong>
            <span style="background: rgba(26, 117, 255, 0.12); color: #66b2ff; border: 1px solid rgba(26, 117, 255, 0.25); padding: 0.5rem 1.2rem; border-radius: 30px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-user-shield"></i> Encargada: Sra. Félipe
            </span>
        </div>
    </nav>

    <!-- Contenedor Principal Adaptativo -->
    <main class="contenedor-maestro">
        @if(session('success'))
            <div style="border-left: 5px solid #4ade80; background: rgba(74, 222, 128, 0.04); padding: 1.25rem; border-radius: 4px; margin-bottom: 2rem;">
                <span class="text-exito" style="font-weight: 700;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </span>
            </div>
        @endif

        @if($errors->any())
            <div style="border-left: 5px solid #f87171; background: rgba(248, 113, 113, 0.04); padding: 1.25rem; border-radius: 4px; margin-bottom: 2rem;">
                <ul style="margin: 0; padding-left: 1.2rem; font-weight: 700;" class="text-peligro">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer Institucional en Conformidad con el Informe Parcial -->
    <footer style="margin-top: 6rem; padding: 2.5rem 0; border-top: 1px solid rgba(255, 255, 255, 0.04); background: rgba(10, 14, 23, 0.65);">
        <div class="contenedor-maestro" style="text-align: center;">
            <p class="subtexto" style="margin: 0; font-size: 0.85rem; line-height: 1.6rem;">
                <strong>KusiMikuy Enterprise Edition v3.8</strong> — Módulo de Presentación Optimizada para el Comedor Popular "Niño Jesús".<br>
                Seguridad perimetral y protección del padrón base de 80 familias en estricta conformidad con la **Ley N° 29733**.
            </p>
        </div>
    </footer>
</body>
</html>
