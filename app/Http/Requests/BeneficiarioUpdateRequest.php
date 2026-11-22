<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Valida la edición de un beneficiario del padrón (RF-02).
 * Igual que el alta, pero el código único ignora al propio registro que se edita.
 */
class BeneficiarioUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->codigo_beneficiario)) {
            $this->merge(['codigo_beneficiario' => strtoupper(trim($this->codigo_beneficiario))]);
        }
    }

    public function rules(): array
    {
        return [
            // {id} es el parámetro de la ruta PUT /beneficiarios/{id}
            'codigo_beneficiario' => [
                'required', 'string', 'max:20',
                Rule::unique('beneficiarios', 'codigo_beneficiario')->ignore($this->route('id')),
            ],
            'tipo_comensal'       => 'required|in:Socio/Cocinera,Público General',
            'raciones_asignadas'  => 'required|integer|min:1|max:4',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_beneficiario.required' => 'Debe ingresar el código del beneficiario (Ej: BEN-CHA-100).',
            'codigo_beneficiario.max'      => 'El código no puede superar los 20 caracteres.',
            'codigo_beneficiario.unique'   => 'Ese código ya pertenece a otro beneficiario del padrón.',
            'tipo_comensal.required'       => 'Debe seleccionar el tipo de comensal.',
            'tipo_comensal.in'             => 'El tipo de comensal debe ser Socio/Cocinera o Público General.',
            'raciones_asignadas.required'  => 'Debe indicar las raciones autorizadas por día.',
            'raciones_asignadas.integer'   => 'Las raciones autorizadas deben ser un número entero.',
            'raciones_asignadas.min'       => 'Debe autorizar al menos 1 ración por día.',
            'raciones_asignadas.max'       => 'No se pueden autorizar más de 4 raciones por día.',
        ];
    }
}