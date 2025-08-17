<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = ['id','nombre', 'estatus'];
    
    public static function getCategoriasPorClub($clubId)
    {
        return self::join('clubes_categorias', 'categorias.id', '=', 'clubes_categorias.categoria_id')
            ->where('clubes_categorias.club_id', $clubId)
            ->select('categorias.*')
            ->get();
    }
}
