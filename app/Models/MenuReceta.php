<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MenuReceta extends Model {
    protected $table = 'menus_recetas';
    protected $fillable = ['nombre_plato', 'insumo_id', 'gramos_por_racion'];
}