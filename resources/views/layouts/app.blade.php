<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KusiMikuy Characato - @yield('title')</title>
    
    <!-- Base estructural ultra-ligera (Cumple RNF-01) -->
    <link rel="stylesheet" href="https://jsdelivr.net">
    <!-- Iconografía avanzada FontAwesome v6 -->
    <link rel="stylesheet" href="https://cloudflare.com">
    
    <style>
        /* Paleta de colores e inyección del fondo oscuro real del curso */
        body {
            background-color: #0b0f19 !important;
            background-image: radial-gradient(at 0% 0%, rgba(26, 117, 255, 0.05) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(56, 176, 0, 0.03) 0px, transparent 50%);
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #e2e8f0;
        }

        /* Contenedores con efecto cristal (Glassmorphism) */
        .card-moderna {
            background: rgba(22, 30, 49, 0.8) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 12px !important;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-moderna:hover {
            border-color: rgba(26, 117, 255, 0.3) !important;
            transform: translateY(-4px);
            box-shadow: 0 12px 40px 0 rgba(26, 117, 255, 0.1);
        }

        /* Botones ergonómicos interactivos WCAG 2.2 con micro-animaciones */
        .btn-premium {
            background: linear-gradient(135deg, #1a75ff, #0052cc) !important;
            border: none !important;
            color: #ffffff !important;
            padding: 1.1rem 1.5rem;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 8px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            min-height: 52px;
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }
        .btn-premium:hover {
            filter: brightness(1.1);
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(26, 117, 255, 0.4);
        }
        .btn-premium.secondary {
            background: rgba(30, 41, 59, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
        }
        .btn-premium.secondary:hover {
            background: rgba(51, 65, 85, 1) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        /* Refinamiento de la barra de navegación superior */
        nav.nav-top {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0.75rem 2rem;
            margin-bottom: 2rem;
        }

        /* Alertas semánticas estilizadas */
        .badge-rol {
            background: rgba(26, 117, 255, 0.15);
            color: #66b2ff;
            border: 1px solid rgba(26, 117, 255, 0.3);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .alert-container {
            border-left: 4px solid #38b000;
            background: rgba(56, 176, 0, 0.05);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
            margin-bottom: 1.5rem;
        }

        /* Tipografía responsiva limpia */
        h2, h3, h4 {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .subtexto { color: #94a3b8; font-size: 0.95rem; }
    </style>
</head>
<body>
    <!-- Menú Superior de Alto Impacto Visual -->
    <nav class="nav-top">
        <ul>
            <li>
                <strong style="font-size: 1.3rem; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-bowl-rice" style="color: #38b000; filter: drop-shadow(0 0 8px #38b000);"></i> 
                    KusiMikuy <span style="color: #1a75ff; font-weight: 300;">Characato</span>
                </strong>
            </li>
        </ul>
        <ul>
            <li>
                <span class="badge-rol">
                    <i class="fa-solid fa-user-shield" style="margin-right: 4px;"></i> Encargada: Sra. Félipe
                </span>
            </li>
        </ul>
    </nav>

    <!-- Área de Inyección de Contenido -->
    <main class="container">
        @if(session('success'))
            <div class="alert-container">
                <span style="color: #38b000; font-weight: bold;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer con alineación ética de datos -->
    <footer class="container" style="margin-top: 4rem; padding-bottom: 2rem;">
        <hr style="border-color: rgba(255, 255, 255, 0.05);">
        <div style="text-align: center; margin-top: 1.5rem;">
            <small class="subtexto">
                <strong>KusiMikuy Framework Frontend v2.5</strong> — Comedor Popular "Niño Jesús" (MPA)<br>
                Garantía Perimetral de Datos Personales en conformidad con la Ley N° 29733.
            </small>
        </div>
    </footer>
</body>
</html>