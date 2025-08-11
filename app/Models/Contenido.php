<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    use HasFactory;
    protected $table = 'contenidos';
    protected $fillable = [ 'title', 'url', 'qr', 'tipo_contenido', 'contenido','descripcion_contenido', 'tipo', 'exhibicion_padre_id', 'estatus',];
}
