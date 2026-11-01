<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KusiMikuy Characato - @yield('title')</title>
    
    <!-- 1. CSS CRÍTICO: Evita parpadeos en blanco y carga los estilos base de inmediato (Anti-FOUC) -->
    <style>
        html, body {
            background-color: #070a12 !important;
            color: #f1f5f9 !important;
            margin: 0; padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        
        /* Botón Premium (Incrustado para carga instantánea) */
        .btn-premium {
            background: linear-gradient(135deg, #1a75ff, #0052cc) !important;
            border: none !important;
            color: #ffffff !important;
            padding: 1rem 1.5rem;
            font-weight: 700;
            border-radius: 10px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            min-height: 54px;
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 15px rgba(26, 117, 255, 0.2);
            width: 100%;
        }
        .btn-premium:hover {
            filter: brightness(1.15);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 117, 255, 0.3);
        }
        .btn-premium.secondary {
            background: rgba(30, 41, 59, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
            box-shadow: none;
            width: auto;
            min-height: 42px;
            padding: 0 1.25rem;
        }
        .btn-premium.secondary:hover {
            background: rgba(51, 65, 85, 0.8) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            transform: none;
        }
        .caja-cristal {
            background: rgba(18, 24, 38, 0.65) !important;
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 14px !important;
            padding: 1.75rem;
        }
        .text-exito { color: #4ade80 !important; }
        .subtexto { color: #94a3b8; font-size: 0.9rem; }
        .ancho-controlado { max-width: 1240px; margin: 0 auto; padding: 0 1.25rem; width: 100%; }
    </style>

    <!-- 2. Enlaces Reales a los Frameworks (Pico CSS y FontAwesome) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- 3. Estilos adicionales de fondo -->
    <style>
        body {
            background-image: radial-gradient(at 0% 0%, rgba(26, 117, 255, 0.1) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(34, 197, 94, 0.08) 0px, transparent 50%) !important;
        }
        nav.menu-superior {
            background: rgba(13, 18, 30, 0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            padding: 0.85rem 0;
            margin-bottom: 2.5rem;
        }
    </style>
</head>
<body>
    <!-- Encabezado de la Plataforma -->
    <nav class="menu-superior">
        <div class="ancho-controlado" style="display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 1.35rem; color: #ffffff; display: flex; align-items: center; gap: 0.5rem; letter-spacing: -0.02em;">
                <i class="fa-solid fa-bowl-rice text-exito" style="filter: drop-shadow(0 0 8px #22c55e);"></i> 
                KusiMikuy <span style="color: #1a75ff; font-weight: 300;">Characato</span>
            </strong>
            <span style="background: rgba(26, 117, 255, 0.1); color: #66b2ff; border: 1px solid rgba(26, 117, 255, 0.2); padding: 0.4rem 1rem; border-radius: 30px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i class="fa-solid fa-user-shield"></i> Sra. Félipe
            </span>
        </div>
    </nav>

    <!-- Inyección de Contenido de Vistas Hijas -->
    <main class="ancho-controlado">
        @yield('content')
    </main>

    <!-- Pie de Página Institucional (Conformidad con la Ley N° 29733) -->
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