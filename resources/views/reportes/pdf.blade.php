<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte MPA</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #1a75ff; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #1a75ff; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .text-right { text-align: right; }
        .vacio { text-align: center; color: #777; }
        .total-box { background: #eef5ff; padding: 15px; border: 1px solid #1a75ff; text-align: right; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KusiMikuy Characato</h1>
        <p>Informe Mensual de Rendición de Cuentas - Comedor "Niño Jesús"</p>
        <p>Período: {{ $mesTexto }} · Fecha de emisión: {{ date('d/m/Y H:i') }}</p>
    </div>

    <h3>1. Resumen Financiero</h3>
    <table>
        <tr><th>Total Ingresos (Cuotas + Subsidios)</th><td class="text-right">S/. {{ number_format($totalIngresos, 2) }}</td></tr>
        <tr><th>Total Gastos (Mercado)</th><td class="text-right">S/. {{ number_format($totalGastos, 2) }}</td></tr>
    </table>
    <div class="total-box">
        <h3>Balance Final: S/. {{ number_format($balance, 2) }}</h3>
    </div>

    <h3>2. Desglose de Ingresos</h3>
    <table>
        <thead><tr><th>Tipo</th><th>Fecha</th><th class="text-right">Operaciones</th><th class="text-right">Monto</th></tr></thead>
        <tbody>
            @forelse($ingresos as $ingreso)
            <tr>
                <td>{{ $ingreso->tipo_ingreso }}</td>
                <td>{{ date('d/m/Y', strtotime($ingreso->fecha_ingreso)) }}</td>
                <td class="text-right">{{ $ingreso->operaciones }}</td>
                <td class="text-right">S/. {{ number_format((float) $ingreso->monto, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="vacio">Sin ingresos registrados en el mes.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>3. Desglose de Gastos</h3>
    <table>
        <thead><tr><th>Concepto</th><th>Comprobante</th><th>Fecha</th><th class="text-right">Monto</th></tr></thead>
        <tbody>
            @forelse($gastos as $gasto)
            <tr>
                <td>{{ $gasto->concepto }}</td>
                <td>{{ $gasto->tipo_comprobante }} {{ $gasto->numero_comprobante }}</td>
                <td>{{ date('d/m/Y', strtotime($gasto->fecha_gasto)) }}</td>
                <td class="text-right">S/. {{ number_format($gasto->monto, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="vacio">Sin gastos registrados en el mes.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>4. Control del Kardex: Consumo de Arroz (tope municipal 6.00 kg/día)</h3>
    <table>
        <thead><tr><th>Fecha</th><th class="text-right">Raciones</th><th class="text-right">Arroz (kg)</th></tr></thead>
        <tbody>
            @forelse($consumoDiario as $dia)
            <tr>
                <td>{{ date('d/m/Y', strtotime($dia->fecha)) }}</td>
                <td class="text-right">{{ $dia->raciones }}</td>
                <td class="text-right">{{ number_format($dia->kg, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="vacio">Sin entregas registradas en el mes.</td></tr>
            @endforelse
            @if($consumoDiario->isNotEmpty())
            <tr><th colspan="2">Total del mes</th><th class="text-right">{{ number_format($totalKg, 2) }}</th></tr>
            @endif
        </tbody>
    </table>

    <h3>5. Mermas Registradas</h3>
    <table>
        <thead><tr><th>Fecha</th><th>Detalle</th><th class="text-right">Cantidad (kg)</th></tr></thead>
        <tbody>
            @forelse($mermas as $merma)
            <tr>
                <td>{{ date('d/m/Y', strtotime($merma->created_at)) }}</td>
                <td>{{ $merma->motivo_detalle }}</td>
                <td class="text-right">{{ number_format($merma->cantidad_kg, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="vacio">Sin mermas registradas en el mes.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>