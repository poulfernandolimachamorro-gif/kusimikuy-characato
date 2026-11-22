<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida el registro y la edición de gastos de caja chica (RF-08).
 */
class GastoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    public function rules(): array
    {
        return [
            'concepto'    => 'required|string|max:200',
            'monto'       => 'required|numeric|min:0.01',
            'fecha_gasto' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'concepto.required'    => 'Debe describir el concepto del gasto.',
            'concepto.max'         => 'El concepto no puede superar los 200 caracteres.',
            'monto.required'       => 'Debe ingresar el monto del gasto.',
            'monto.numeric'        => 'El monto debe ser un número.',
            'monto.min'            => 'El monto debe ser mayor a S/. 0.00.',
            'fecha_gasto.required' => 'Debe indicar la fecha del gasto.',
            'fecha_gasto.date'     => 'La fecha del gasto no es válida.',
        ];
    }
}