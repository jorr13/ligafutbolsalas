<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenidoImagenes extends Model
{
    use HasFactory;

    protected $table = 'contenido_imagenes'; // Especifica la tabla
    protected $fillable = [ 'contenido_id', 'titulo', 'descripcion', 'imagen_url','created_at','updated_at'];
}
