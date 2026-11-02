<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'beneficiarios';
    
    protected $fillable = [
        'codigo_beneficiario',
        'tipo_comensal',
        'cantidad_integrantes',
        'raciones_asignadas',
        'fecha_incorporacion',
        'estado'
    ];
}