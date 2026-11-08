<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KusiMikuy Characato - Acceso Seguro</title>

    <!-- Estilos base (se cargan antes para evitar el parpadeo sin estilos) -->
    <style>
        html, body {
            background-color: #070a12 !important;
            color: #f1f5f9 !important;
            margin: 0; padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(at 0% 0%, rgba(26, 117, 255, 0.1) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(34, 197, 94, 0.08) 0px, transparent 50%) !important;
        }
        .login-card {
            background: rgba(18, 24, 38, 0.65) !important;
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .input-dark {
            background-color: #0f1422 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 0.75rem 1rem !important;
            width: 100%;
            margin-top: 0.5rem;
        }
        .input-dark:focus {
            border-color: #1a75ff !important;
            outline: none;
            box-shadow: 0 0 12px rgba(26, 117, 255, 0.2) !important;
        }
        .btn-premium {
            background: linear-gradient(135deg, #1a75ff, #0052cc) !important;
            color: white !important;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            width: 100%;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        .btn-premium:hover {
            filter: brightness(1.15);
            transform: translateY(-2px);
        }
        .text-link {
            color: #66b2ff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .text-link:hover {
            color: #ffffff;
        }
        label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #cbd5e1;
        }
    </style>
    
    <!-- Estilos de Pico e íconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-card">
        <!-- Logo y título -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <i class="fa-solid fa-bowl-rice" style="font-size: 3rem; color: #22c55e; filter: drop-shadow(0 0 10px #22c55e); margin-bottom: 1rem;"></i>
            <h2 style="color: white; font-weight: 800; margin: 0; font-size: 1.8rem;">KusiMikuy <span style="color: #1a75ff; font-weight: 300;">Characato</span></h2>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.5rem;">Acceso Seguro al Sistema de Gestión</p>
        </div>

        <!-- Aquí se muestra el contenido de cada vista (login, registro, etc.) -->
        {{ $slot }}
        
    </div>
</body>
</html>