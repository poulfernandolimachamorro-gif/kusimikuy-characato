<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida el alta de lotes de inventario (RF-09).
 * El insumo debe existir y el estado de calidad debe ser uno de los tres valores del ENUM.
 */
class LoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    /** Normaliza el código (sin espacios y en mayúsculas), p. ej. "l-arr-02" pasa a "L-ARR-02". */
    protected function prepareForValidation(): void
    {
        if (is_string($this->codigo_lote)) {
            $this->merge(['codigo_lote' => strtoupper(trim($this->codigo_lote))]);
        }
    }

    public function rules(): array
    {
        return [
            'insumo_id'         => 'required|integer|exists:insumos,id',
            'codigo_lote'       => 'required|string|max:50',
            'fecha_vencimiento' => 'nullable|date',
            'estado_calidad'    => 'required|in:Óptimo,Defectuoso/Verde,Mermado',
        ];
    }

    public function messages(): array
    {
        return [
            'insumo_id.required'        => 'Debe seleccionar el insumo del lote.',
            'insumo_id.integer'         => 'El insumo seleccionado no es válido.',
            'insumo_id.exists'          => 'El insumo seleccionado no existe en el almacén.',
            'codigo_lote.required'      => 'Debe ingresar el código del lote (Ej: L-ARR-02).',
            'codigo_lote.max'           => 'El código del lote no puede superar los 50 caracteres.',
            'fecha_vencimiento.date'    => 'La fecha de vencimiento no es válida.',
            'estado_calidad.required'   => 'Debe indicar el estado de calidad del lote.',
            'estado_calidad.in'         => 'El estado de calidad debe ser Óptimo, Defectuoso/Verde o Mermado.',
        ];
    }
}