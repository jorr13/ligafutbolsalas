<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = ['id', 'nombre', 'estatus', 'edad_min', 'edad_max'];
    
    public static function getCategoriasPorClub($clubId)
    {
        return self::join('clubes_categorias', 'categorias.id', '=', 'clubes_categorias.categoria_id')
            ->where('clubes_categorias.club_id', $clubId)
            ->select('categorias.*')
            ->get();
    }

    /**
     * Obtiene categorías del club que coinciden con la edad del jugador.
     * Si $edad es null, devuelve todas las categorías del club.
     * Si $edad tiene valor, solo devuelve categorías con edad_min <= edad <= edad_max.
     */
    public static function getCategoriasPorClubYEdad($clubId, ?int $edad)
    {
        $query = self::join('clubes_categorias', 'categorias.id', '=', 'clubes_categorias.categoria_id')
            ->where('clubes_categorias.club_id', $clubId)
            ->select('categorias.*');

        if ($edad !== null) {
            $query->whereNotNull('categorias.edad_min')
                ->whereNotNull('categorias.edad_max')
                ->where('categorias.edad_min', '<=', $edad)
                ->where('categorias.edad_max', '>=', $edad);
        }

        return $query->orderBy('categorias.edad_min')->get();
    }
}
