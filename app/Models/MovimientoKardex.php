<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoKardex extends Model
{
    protected $table = 'movimientos_kardex';

    // Desactivamos los campos automáticos tradicionales ya que usamos created_at inmutable nativo
    public $timestamps = false; 

    protected $fillable = [
        'beneficiario_id',
        'usuario_id',
        'tipo_movimiento',
        'cantidad_kg',
        'motivo_detalle'
    ];

    protected $casts = [
        'cantidad_kg' => 'decimal:2',
        'created_at' => 'datetime'
    ];

    /**
     * Enlace inverso hacia el padrón de beneficiarios.
     */
    public function beneficiario(): BelongsTo
    {
        return $this->belongsTo(Beneficiario::class, 'beneficiario_id');
    }

    /**
     * Enlace inverso para auditar qué usuario del equipo registró la transacción.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}