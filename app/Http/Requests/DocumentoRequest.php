<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida el registro de documentos legales (RF-05).
 * La caducidad debe ser posterior a la emisión para que el cálculo de vigencia sea coherente.
 */
class DocumentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->rol === 'Encargada';
    }

    public function rules(): array
    {
        return [
            'tipo_documento'  => 'required|in:Resolución Municipal,Registros Públicos,Libro de Actas Mensual',
            'fecha_emision'   => 'required|date',
            'fecha_caducidad' => 'required|date|after:fecha_emision',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_documento.required'  => 'Debe seleccionar el tipo de documento.',
            'tipo_documento.in'        => 'El tipo debe ser Resolución Municipal, Registros Públicos o Libro de Actas Mensual.',
            'fecha_emision.required'   => 'Debe indicar la fecha de emisión.',
            'fecha_emision.date'       => 'La fecha de emisión no es válida.',
            'fecha_caducidad.required' => 'Debe indicar la fecha de caducidad.',
            'fecha_caducidad.date'     => 'La fecha de caducidad no es válida.',
            'fecha_caducidad.after'    => 'La fecha de caducidad debe ser posterior a la fecha de emisión.',
        ];
    }
}