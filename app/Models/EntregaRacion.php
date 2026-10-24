<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaRacion extends Model
{
    use HasFactory;

    protected $table = 'entregas_raciones';
    
    protected $fillable = [
        'beneficiario_id',
        'fecha_entrega',
        'raciones_retiradas',
        'cuota_cobrada'
    ];
}