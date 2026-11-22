<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida el alta de un beneficiario en el padrón (RF-02).
 *
 * La ruta ya está protegida por el middleware "rol:Encargada"; authorize() es una
 * segunda barrera por si la clase se reutiliza en otra ruta.
 */
class BeneficiarioStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    /** Normaliza el código (sin espacios y en mayúsculas) para evitar duplicados por tipeo. */
    protected function prepareForValidation(): void
    {
        if (is_string($this->codigo_beneficiario)) {
            $this->merge(['codigo_beneficiario' => strtoupper(trim($this->codigo_beneficiario))]);
        }
    }

    public function rules(): array
    {
        return [
            'codigo_beneficiario'  => 'required|string|max:20|unique:beneficiarios,codigo_beneficiario',
            'tipo_comensal'        => 'required|in:Socio/Cocinera,Público General',
            'cantidad_integrantes' => 'required|integer|min:1',
            'raciones_asignadas'   => 'required|integer|min:1|max:4',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_beneficiario.required' => 'Debe ingresar el código del beneficiario (Ej: BEN-CHA-100).',
            'codigo_beneficiario.max'      => 'El código no puede superar los 20 caracteres.',
            'codigo_beneficiario.unique'   => 'Ese código ya está registrado en el padrón.',
            'tipo_comensal.required'       => 'Debe seleccionar el tipo de comensal.',
            'tipo_comensal.in'             => 'El tipo de comensal debe ser Socio/Cocinera o Público General.',
            'cantidad_integrantes.required' => 'Debe indicar la cantidad de integrantes de la familia.',
            'cantidad_integrantes.integer'  => 'La cantidad de integrantes debe ser un número entero.',
            'cantidad_integrantes.min'      => 'La familia debe tener al menos 1 integrante.',
            'raciones_asignadas.required'  => 'Debe indicar las raciones autorizadas por día.',
            'raciones_asignadas.integer'   => 'Las raciones autorizadas deben ser un número entero.',
            'raciones_asignadas.min'       => 'Debe autorizar al menos 1 ración por día.',
            'raciones_asignadas.max'       => 'No se pueden autorizar más de 4 raciones por día.',
        ];
    }
}