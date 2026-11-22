<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida el formulario de marcado de asistencia (RF-03).
 * Lo usan la Encargada y el Voluntario, por eso solo exige sesión iniciada.
 * La tarifa no se envía: se toma del padrón según el código ingresado.
 */
class AsistenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** Normaliza el código (sin espacios y en mayúsculas) para que "ben-cha-001" también funcione. */
    protected function prepareForValidation(): void
    {
        if (is_string($this->codigo_beneficiario)) {
            $this->merge(['codigo_beneficiario' => strtoupper(trim($this->codigo_beneficiario))]);
        }
    }

    public function rules(): array
    {
        return [
            'codigo_beneficiario' => 'required|string|max:20',
            'raciones_retiradas'  => 'required|integer|min:1|max:4',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_beneficiario.required' => 'Debe ingresar el código del comensal.',
            'codigo_beneficiario.max'      => 'El código no puede superar los 20 caracteres.',
            'raciones_retiradas.required'  => 'Debe indicar cuántas raciones retira.',
            'raciones_retiradas.integer'   => 'Las raciones deben ser un número entero.',
            'raciones_retiradas.min'       => 'Debe retirar al menos 1 ración.',
            'raciones_retiradas.max'       => 'No se pueden retirar más de 4 raciones por persona.',
        ];
    }
}