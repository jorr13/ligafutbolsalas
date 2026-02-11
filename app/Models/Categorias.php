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

    /**
     * Clave de categoría por año de nacimiento (tabla L.F.S.C.): Sub-18 (2009-2010), Sub-16 (2011-2012), etc.
     * Sub-8 es excepción: se asigna por edad 0-7 años, no por año.
     * Retorna 'sub8','sub10',...,'sub18' o null si edad >= 18.
     */
    public static function getClaveCategoriaPorFechaNacimiento(?string $fechaNacimiento): ?string
    {
        if (!$fechaNacimiento) {
            return null;
        }
        try {
            $fecha = \Carbon\Carbon::parse($fechaNacimiento);
            $edad = $fecha->age;
            $añoNacimiento = (int) $fecha->format('Y');
            $añoActual = (int) date('Y');

            if ($edad >= 18) {
                return null;
            }
            // Sub-8: edades 0 a 7 (por edad, no por año)
            if ($edad <= 7) {
                return 'sub8';
            }
            // Resto por año de nacimiento (Sub-18 a Sub-10)
            if (in_array($añoNacimiento, [$añoActual - 17, $añoActual - 16])) {
                return 'sub18';
            }
            if (in_array($añoNacimiento, [$añoActual - 15, $añoActual - 14])) {
                return 'sub16';
            }
            if (in_array($añoNacimiento, [$añoActual - 13, $añoActual - 12])) {
                return 'sub14';
            }
            if (in_array($añoNacimiento, [$añoActual - 11, $añoActual - 10])) {
                return 'sub12';
            }
            if (in_array($añoNacimiento, [$añoActual - 9, $añoActual - 8])) {
                return 'sub10';
            }
            return 'sub8';
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Busca en una colección de categorías la que coincida con la clave (sub8, sub10, ..., sub18).
     */
    public static function findCategoriaIdPorClave($categorias, string $clave): ?int
    {
        $numero = (int) preg_replace('/[^0-9]/', '', $clave);
        $cat = $categorias->first(function ($c) use ($numero) {
            return preg_match('/sub[_\-]?\s*' . $numero . '\b/i', trim($c->nombre ?? ''));
        });

        return $cat ? $cat->id : null;
    }
}
