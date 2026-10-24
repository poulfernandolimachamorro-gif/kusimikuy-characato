<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KusiMikuy Characato - @yield('title')</title>
    
    <!-- Framework Ultra-ligero Pico CSS v2 (Cumple RNF-01 de carga eficiente) -->
    <link rel="stylesheet" href="https://jsdelivr.net">
    
    <!-- Iconografía Semántica FontAwesome v6 para Mitigar Barreras de Alfabetización Digital -->
    <link rel="stylesheet" href="https://cloudflare.com">
    
    <style>
        :root {
            --pico-font-size: 100%;
            --pico-border-radius: 0.5rem;
        }
        /* Botones ergonómicos sobredimensionados según criterios WCAG 2.2 (Target Size) */
        .btn-ergonomico {
            padding: 1.1rem 1.5rem;
            font-size: 1.15rem;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 48px; /* Éxito SC 2.5.8 Target Size Minimum */
        }
        .card-dinamica {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--pico-muted-border-color);
        }
        .text-exito { color: #38b000; }
        .text-alerta { color: #ffb703; }
        .text-peligro { color: #d00000; }
    </style>
</head>
<body>
    <!-- Encabezado de Navegación de la Plataforma Asistencial -->
    <header class="container">
        <nav>
            <ul>
                <li>
                    <strong>
                        <i class="fa-solid fa-bowl-rice text-exito"></i> KusiMikuy Characato
                    </strong>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="badge secondary">
                        <i class="fa-solid fa-user-shield"></i> {{ auth()->user()->nombre ?? 'Encargada (Sra. Félipe)' }}
                    </span>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Contenedor Dinámico Principal para Inyección de Vistas -->
    <main class="container">
        <!-- Intercepción y Renderizado Seguro de Mensajes de Éxito de Transacciones Atómicas -->
        @if(session('success'))
            <article style="border-left: 6px solid #38b000; padding: 1rem; margin-bottom: 1.5rem;">
                <p style="margin: 0; font-weight: bold;" class="text-exito">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </p>
            </article>
        @endif

        <!-- Mensajes de Error del Servidor o Validación de Restricciones del Negocio -->
        @if($errors->any())
            <article style="border-left: 6px solid #d00000; padding: 1rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach($errors->all() as $error)
                        <li class="text-peligro" style="font-weight: bold;">{{ $error }}</li>
                    @endforeach
                </ul>
            </article>
        @endif

        @yield('content')
    </main>

    <!-- Pie de Página Institucional - Marco Regulatorio y Privacidad de Datos -->
    <footer class="container">
        <hr>
        <div style="text-align: center; margin-top: 1rem;">
            <small>
                <strong>KusiMikuy v2.0</strong> — Comedor Popular Niño Jesús | Supervisado por la Municipalidad Provincial de Arequipa (MPA).<br>
                Capa de Presentación acoplada al cumplimiento perimetral de la Ley N° 29733 (Protección de Datos Personales).
            </small>
        </div>
    </footer>
</body>
</html>
