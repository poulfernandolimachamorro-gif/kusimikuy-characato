<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DocumentoLegal extends Model {
    protected $table = 'documentos_legales';
    protected $fillable = ['tipo_documento', 'fecha_emision', 'fecha_caducidad', 'archivo_path'];
}