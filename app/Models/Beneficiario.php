<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiario extends Model
{
    use SoftDeletes;

    protected $table = 'beneficiarios';

    protected $fillable = [
        'codigo_beneficiario',
        'tipo_comensal',
        'cantidad_integrantes',
        'raciones_asignadas',
        'fecha_incorporacion',
        'estado'
    ];

    protected $casts = [
        'fecha_incorporacion' => 'date',
        'estado' => 'boolean',
    ];
}

