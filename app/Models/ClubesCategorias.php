<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubesCategorias extends Model
{
    use HasFactory;
    protected $table = 'clubes_categorias';
    protected $fillable = ['club_id','categoria_id'];
}