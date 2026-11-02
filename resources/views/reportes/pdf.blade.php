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
        .total-box { background: #eef5ff; padding: 15px; border: 1px solid #1a75ff; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KusiMikuy Characato</h1>
        <p>Informe de Rendición de Cuentas - Comedor "Niño Jesús"</p>
        <p>Fecha de emisión: {{ date('d/m/Y H:i A') }}</p>
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
        <thead><tr><th>Tipo</th><th>Fecha</th><th class="text-right">Monto</th></tr></thead>
        <tbody>
            @foreach($ingresos as $ingreso)
            <tr>
                <td>{{ $ingreso->tipo_ingreso }}</td>
                <td>{{ date('d/m/Y', strtotime($ingreso->fecha_ingreso)) }}</td>
                <td class="text-right">S/. {{ number_format($ingreso->monto, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>