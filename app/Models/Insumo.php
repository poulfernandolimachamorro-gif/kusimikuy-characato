<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';
    protected $fillable = [
        'nombre_insumo', 
        'stock_actual', 
        'stock_minimo_alerta', 
        'limite_consumo_diario', 
        'unidad_medida'
    ];
}