<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LoteInventario extends Model {
    protected $table = 'lotes_inventario';
    protected $fillable = ['insumo_id', 'codigo_lote', 'fecha_vencimiento', 'estado_calidad'];
}