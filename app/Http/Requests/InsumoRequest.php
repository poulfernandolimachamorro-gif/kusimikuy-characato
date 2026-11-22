<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida el alta y la edición de insumos del almacén (RF-07).
 * Las reglas son las mismas en ambos casos, por eso comparten esta clase.
 */
class InsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    public function rules(): array
    {
        return [
            'nombre_insumo' => 'required|string|max:100',
            'stock_actual'  => 'required|numeric|min:0',
            'unidad_medida' => 'required|in:Kilogramos,Litros,Unidades,Sacos',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_insumo.required' => 'Debe ingresar el nombre del insumo.',
            'nombre_insumo.max'      => 'El nombre del insumo no puede superar los 100 caracteres.',
            'stock_actual.required'  => 'Debe indicar el stock actual.',
            'stock_actual.numeric'   => 'El stock debe ser un número.',
            'stock_actual.min'       => 'El stock no puede ser negativo.',
            'unidad_medida.required' => 'Debe seleccionar la unidad de medida.',
            'unidad_medida.in'       => 'La unidad debe ser Kilogramos, Litros, Unidades o Sacos.',
        ];
    }
}