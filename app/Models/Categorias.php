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
     * Determina la categoría según el año de nacimiento (tabla L.F.S.C.).
     * TODAS las categorías se asignan por año de nacimiento, no por edad actual.
     * Basado en:
     * - SUB-8:  2019-2020 (6 y 7 años)
     * - SUB-10: 2017-2018 (8 y 9 años)
     * - SUB-12: 2015-2016 (10 y 11 años)
     * - SUB-14: 2013-2014 (12 y 13 años)
     * - SUB-16: 2011-2012 (14 y 15 años)
     * - SUB-18: 2009-2010 (16 y 17 años)
     * 
     * Retorna 'sub8','sub10',...,'sub18' o null si es mayor de 18 años.
     */
    public static function getClaveCategoriaPorFechaNacimiento(?string $fechaNacimiento): ?string
    {
        if (!$fechaNacimiento) {
            return null;
        }
        try {
            $fecha = \Carbon\Carbon::parse($fechaNacimiento);
            $añoNacimiento = (int) $fecha->format('Y');
            $añoActual = (int) date('Y');
            $edadEnAñoActual = $añoActual - $añoNacimiento;

            // Mayor de 18 años
            if ($edadEnAñoActual >= 18) {
                return null;
            }

            // SUB-18: nacidos 2009-2010 (16 y 17 años)
            if (in_array($añoNacimiento, [$añoActual - 17, $añoActual - 16])) {
                return 'sub18';
            }

            // SUB-16: nacidos 2011-2012 (14 y 15 años)
            if (in_array($añoNacimiento, [$añoActual - 15, $añoActual - 14])) {
                return 'sub16';
            }

            // SUB-14: nacidos 2013-2014 (12 y 13 años)
            if (in_array($añoNacimiento, [$añoActual - 13, $añoActual - 12])) {
                return 'sub14';
            }

            // SUB-12: nacidos 2015-2016 (10 y 11 años)
            if (in_array($añoNacimiento, [$añoActual - 11, $añoActual - 10])) {
                return 'sub12';
            }

            // SUB-10: nacidos 2017-2018 (8 y 9 años)
            if (in_array($añoNacimiento, [$añoActual - 9, $añoActual - 8])) {
                return 'sub10';
            }

            // SUB-8: nacidos 2019-2020 (6 y 7 años) y menores
            // Jugadores menores de 6 años también van a SUB-8
            if ($edadEnAñoActual <= 7) {
                return 'sub8';
            }

            return null;
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
