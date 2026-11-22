@extends('layouts.app')

@section('title', 'Control de Asistencia')

@section('content')
<!-- Estilos propios del módulo (en este proyecto cada vista define los suyos) -->
<style>
    @keyframes entradaSuave {
        from { opacity: 0; transform: translateY(15px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .contenedor-animado { animation: entradaSuave 0.40s cubic-bezier(0.16, 1, 0.3, 1) both; }

    .caja-cristal {
        background: rgba(18, 24, 38, 0.65) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 14px !important;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .input-asistencia-premium {
        background-color: #0f1422 !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        padding: 0.7rem 1rem !important;
        font-size: 0.95rem !important;
        margin-bottom: 0 !important;
    }
    .input-asistencia-premium:focus {
        border-color: #1a75ff !important;
        outline: none;
    }

    /* Resumen: 2 columnas en móvil, 4 en pantallas anchas */
    .rejilla-resumen {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 768px) {
        .rejilla-resumen { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    }
    .tarjeta-dato { text-align: center; margin: 0 !important; }
    .tarjeta-dato .etiqueta { color: #94a3b8; font-size: 0.85rem; }
    .tarjeta-dato .valor { font-size: 1.8rem; font-weight: 800; color: #ffffff; }

    .tabla-asistencia { width: 100%; border-collapse: collapse; color: #cbd5e1; min-width: 520px; }
    .tabla-asistencia th {
        padding: 0.9rem 1rem; text-align: left;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }
    .tabla-asistencia td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .alerta-error {
        background: rgba(239, 68, 68, 0.1);
        border-left: 4px solid #ef4444;
        color: #fca5a5;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
</style>

<div class="contenedor-animado">
    <!-- Barra superior: título, fecha consultada y acceso al marcado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <h2 style="color: white; font-weight: 800; margin: 0;">
            <i class="fa-solid fa-clipboard-user" style="color: #60a5fa;"></i> Control de Asistencia Diaria
        </h2>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('asistencia.index') }}" class="btn-premium" style="width: auto; min-height: 40px; padding: 0 1rem;">
                <i class="fa-solid fa-pen-to-square"></i> Registrar asistencia
            </a>
            <a href="{{ route('dashboard') }}" class="btn-premium secondary" style="width: auto; min-height: 40px; padding: 0 1rem;">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Errores de validación del filtro (por ejemplo, una fecha futura) -->
    @if($errors->any())
        <div class="alerta-error">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <!-- Filtro por fecha -->
    <div class="caja-cristal">
        <form action="{{ route('asistencia.control') }}" method="GET" style="display: flex; gap: 0.75rem; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label for="fecha" style="color: #cbd5e1; display: block; margin-bottom: 0.4rem;">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="{{ $fecha }}" max="{{ now()->toDateString() }}" class="input-asistencia-premium">
            </div>
            <button type="submit" class="btn-premium" style="width: auto; min-height: 44px;">Consultar</button>
            <a href="{{ route('asistencia.control', ['fecha' => $fecha]) }}" class="btn-premium secondary" style="width: auto; min-height: 44px;">Todos</a>
            <a href="{{ route('asistencia.control', ['fecha' => $fecha, 'ausentes' => 1]) }}" class="btn-premium secondary" style="width: auto; min-height: 44px;">Solo ausentes</a>
        </form>
    </div>

    <!-- Resumen de la jornada -->
    <div class="rejilla-resumen">
        <div class="caja-cristal tarjeta-dato">
            <div class="etiqueta">Padrón activo</div>
            <div class="valor">{{ $totalPadron }}</div>
        </div>
        <div class="caja-cristal tarjeta-dato">
            <div class="etiqueta">Asistieron</div>
            <div class="valor" style="color: #4ade80;">{{ $asistieron }}</div>
        </div>
        <div class="caja-cristal tarjeta-dato">
            <div class="etiqueta">No asistieron</div>
            <div class="valor" style="color: #f87171;">{{ $ausentes }}</div>
        </div>
        <div class="caja-cristal tarjeta-dato">
            <div class="etiqueta">% de asistencia</div>
            <div class="valor">{{ $porcentaje }}%</div>
        </div>
    </div>

        <!-- Cupo disponible del día (tope municipal de 6.00 kg = 40 raciones) -->
    <div class="caja-cristal" style="{{ $cupoDisponible === 0 ? 'border-color: rgba(239, 68, 68, 0.3) !important;' : '' }}">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; font-weight: 600; font-size: 0.95rem;">
            <span style="color: #cbd5e1;"><i class="fa-solid fa-bowl-rice" style="color: #facc15;"></i> Cupo de raciones del día</span>
            <span style="color: {{ $cupoDisponible === 0 ? '#f87171' : '#4ade80' }};">
                Disponible: {{ $cupoDisponible }} de {{ $cupoRaciones }}
            </span>
        </div>
        <progress value="{{ min($racionesServidas, $cupoRaciones) }}" max="{{ $cupoRaciones }}" style="width: 100%; height: 10px; margin-top: 0.75rem;"></progress>
        <p class="subtexto" style="margin: 0.6rem 0 0 0;">
            Raciones servidas: <strong style="color: #ffffff;">{{ $racionesServidas }}</strong> de {{ $cupoRaciones }}
            permitidas por el tope municipal diario (6.00 kg de arroz).
            @if($esHoy && $cupoDisponible === 0)
                <strong style="color: #f87171;">Cupo completo: no se pueden registrar más raciones hoy.</strong>
            @endif
        </p>
    </div>

    <!-- Suplentes sugeridos: solo para la jornada de hoy y mientras quede cupo -->
    @if($esHoy && $cupoDisponible > 0)
    <div class="caja-cristal" style="overflow-x: auto;">
        <h4 style="margin: 0 0 0.25rem 0; color: #ffffff;">
            <i class="fa-solid fa-user-clock" style="color: #60a5fa;"></i> Suplentes sugeridos
        </h4>
        <p class="subtexto" style="margin: 0 0 1rem 0;">
            Ausentes de hoy con menos asistencias en los últimos 30 días, para aprovechar el cupo restante.
        </p>
        <table class="tabla-asistencia">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo de comensal</th>
                    <th>Raciones autorizadas</th>
                    <th>Asistencias (30 días)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suplentes as $suplente)
                <tr>
                    <td style="font-weight: bold; color: #66b2ff;">{{ $suplente->codigo_beneficiario }}</td>
                    <td>{{ $suplente->tipo_comensal }}</td>
                    <td>{{ $suplente->raciones_asignadas }}</td>
                    <td>{{ $suplente->asistencias_30d }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #94a3b8; padding: 1.5rem;">
                        No hay ausentes disponibles: todos los beneficiarios ya asistieron hoy.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <!-- Detalle por beneficiario -->
    <div class="caja-cristal" style="overflow-x: auto;">
        <table class="tabla-asistencia">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo de comensal</th>
                    <th>Retiró / Autorizadas</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listado as $beneficiario)
                <tr>
                    <td style="font-weight: bold; color: #66b2ff;">{{ $beneficiario->codigo_beneficiario }}</td>
                    <td>{{ $beneficiario->tipo_comensal }}</td>
                    <td>{{ $beneficiario->raciones_retiradas }} / {{ $beneficiario->raciones_asignadas }}</td>
                    <td>
                        @if($beneficiario->asistio)
                            <span style="color: #4ade80; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Asistió</span>
                        @else
                            <span style="color: #f87171; font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> No asistió</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #94a3b8; padding: 1.5rem;">
                        @if($soloAusentes)
                            Todos los beneficiarios asistieron en esta fecha.
                        @else
                            No hay beneficiarios en el padrón para esta fecha.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection