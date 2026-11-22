<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

/**
 * Valida el alta de menús y recetas (RF-10): plato, insumo existente y con stock, y gramos por ración.
 */
class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    public function rules(): array
    {
        return [
            'nombre_plato' => 'required|string|max:150',
            'insumo_id'    => [
                'bail', 'required', 'integer', 'exists:insumos,id',
                // Algoritmo 1: un insumo agotado bloquea la planificación de menús que lo requieran
                function (string $attribute, mixed $value, \Closure $fail) {
                    if ((float) DB::table('insumos')->where('id', $value)->value('stock_actual') <= 0) {
                        $fail('El insumo seleccionado está agotado: no se puede planificar un menú que lo requiera.');
                    }
                },
            ],
            // La columna es DECIMAL(6,2): el máximo representable es 9999.99
            'gramos_por_racion' => 'required|numeric|min:0.01|max:9999.99',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_plato.required'      => 'Debe ingresar el nombre del plato.',
            'nombre_plato.max'           => 'El nombre del plato no puede superar los 150 caracteres.',
            'insumo_id.required'         => 'Debe seleccionar el insumo de la receta.',
            'insumo_id.integer'          => 'El insumo seleccionado no es válido.',
            'insumo_id.exists'           => 'El insumo seleccionado no existe en el almacén.',
            'gramos_por_racion.required' => 'Debe indicar los gramos por ración.',
            'gramos_por_racion.numeric'  => 'Los gramos por ración deben ser un número.',
            'gramos_por_racion.min'      => 'Los gramos por ración deben ser mayores a 0.',
            'gramos_por_racion.max'      => 'Los gramos por ración no pueden superar 9999.99.',
        ];
    }
}