<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoteInventario extends Model
{
    protected $table = 'lotes_inventario';
    
    protected $fillable = [
        'insumo_id', 
        'codigo_lote', 
        'fecha_vencimiento', 
        'estado_calidad'
    ];

    /**
     * Relación: Un lote pertenece a un insumo.
     */
    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }
}