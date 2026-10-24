<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Beneficiario; // Enlace al Modelo Eloquent del Padrón Semilla
use App\Models\EntregaRacion; // Bitácora Atómica de Entregas Diario

/**
 * Controller: BeneficiarioController
 * Capa de Control del MVC encargada de interceptar las peticiones HTTP
 * y delegar el cómputo algorítmico de porciones de almacén.
 */
class BeneficiarioController extends Controller
{
    /**
     * Procesar transacciones atómicas de asistencia y cobro diferenciado (S/. 5.00 / S/. 8.00)
     * Cumple de forma perimetral con los requerimientos funcionales RF-03 y RF-04.
     */
    public function store(Request $request)
    {
        // 1. Capa de Validación Estricta para mitigar ataques XSS e Inyecciones SQL
        $validated = $request->validate([
            'codigo_beneficiario' => 'required|string|max:20|exists:beneficiarios,codigo_beneficiario',
            'tipo_comensal'        => 'required|in:Socio/Cocinera,Público General',
            'raciones_retiradas'   => 'required|integer|min:1|max:4',
            'exonerado'            => 'nullable|boolean'
        ]);

        // 2. Localizar al beneficiario activo anonimizado dentro del padrón base de 80 familias
        $beneficiario = DB::table('beneficiarios')
            ->where('codigo_beneficiario', $validated['codigo_beneficiario'])
            ->where('estado', true)
            ->first();

        if (!$beneficiario) {
            return redirect()->back()->withErrors(['error' => 'El comensal consultado no figura como Activo en el sistema.']);
        }

        // 3. Algoritmo de Control: Fiscalización del Límite de 6.00 kg de Arroz diario de la MPA
        $gramosPorRacion = 150.00; // Constante de la receta parametrizada en gramos por ración
        $gastoArrozActual = ($validated['raciones_retiradas'] * $gramosPorRacion) / 1000; // Conversión a Kilogramos

        // Sumar consumos procesados con éxito en la fecha actual
        $arrozConsumidoHoy = DB::table('entregas_raciones')
            ->where('fecha_entrega', date('Y-m-d'))
            ->sum(DB::raw('raciones_retiradas * 0.15'));

        $totalProyectado = $arrozConsumidoHoy + $gastoArrozActual;
        $limiteRígidoMunicipal = 6.00; // Tope rígido parametrizado en la sección 3.4 del informe

        if ($totalProyectado > $limiteRígidoMunicipal) {
            return redirect()->back()->withErrors([
                'limite' => "Transacción abortada: La orden de raciones excede la cuota física permitida de 6 kg de arroz diarios por la MPA. Restan únicamente " . number_format($limiteRígidoMunicipal - $arrozConsumidoHoy, 2) . " kg."
            ]);
        }

        // 4. Automatización del cálculo de tarifas sociales (RF-03): S/. 5.00 o S/. 8.00
        $tarifaBase = ($validated['tipo_comensal'] === 'Socio/Cocinera') ? 5.00 : 8.00;
        $cuotaSocialCalculada = $validated['raciones_retiradas'] * $tarifaBase;

        // Evaluar la exoneración excepcional por vulnerabilidad crítica (Anexo A)
        if ($request->has('exonerado')) {
            $cuotaSocialCalculada = 0.00;
        }

        // 5. Inyección Atómica de Datos utilizando Transacciones SQL para blindar el Kardex
        DB::beginTransaction();
        try {
            // Guardar el registro diario en la bitácora de entregas
            $entregaId = DB::table('entregas_raciones')->insertGetId([
                'beneficiario_id'    => $beneficiario->id,
                'fecha_entrega'      => date('Y-m-d'),
                'raciones_retiradas' => $validated['raciones_retiradas'],
                'cuota_cobrada'      => $cuotaSocialCalculada,
                'created_at'         => now(),
                'updated_at'         => now()
            ]);

            // Alimentar la tabla ingresos_caja de forma sincronizada
            DB::table('ingresos_caja')->insert([
                'tipo_ingreso'  => 'Cuotas Diarias',
                'monto'         => $cuotaSocialCalculada,
                'fecha_ingreso' => date('Y-m-d'),
                'entrega_id'    => $entregaId,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            // Descontar físicamente las existencias del insumo base (Arroz Común) en la tabla insumos
            DB::table('insumos')
                ->where('nombre_insumo', 'Arroz Común')
                ->decrement('stock_actual', $gastoArrozActual);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Asistencia registrada con éxito. S/. ' . number_format($cuotaSocialCalculada, 2) . ' integrados a Caja Chica.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['db' => 'Fallo crítico en la base de datos relacional: ' . $e->getMessage()]);
        }
    }
}