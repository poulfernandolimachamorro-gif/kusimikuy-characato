<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntregaRacion extends Model
{
    protected $table = 'entregas_raciones';

    protected $fillable = [
        'beneficiario_id',
        'fecha_entrega',
        'raciones_retiradas',
        'cuota_cobrada'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'cuota_cobrada' => 'decimal:2'
    ];

    /**
     * Relación inversa: Una entrega de ración pertenece a un único beneficiario adscrito.
     */
    public function beneficiario(): BelongsTo
    {
        return $this->belongsTo(Beneficiario::class, 'beneficiario_id');
    }
}