<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AjustarCategoriasJugadoresPorAnioNacimiento extends Migration
{
    /**
     * Run the migrations.
     * Ajusta la categoría de jugadores existentes según su año de nacimiento,
     * siguiendo la tabla L.F.S.C.:
     * - Sub-18: 2009-2010
     * - Sub-16: 2011-2012
     * - Sub-14: 2013-2014
     * - Sub-12: 2015-2016
     * - Sub-10: 2017-2018
     * - Sub-8: edad 0-7 años
     *
     * @return void
     */
    public function up()
    {
        // Obtener todas las categorías
        $todasCategorias = DB::table('categorias')->get();

        // Obtener todos los jugadores con fecha de nacimiento
        $jugadores = DB::table('jugadores')
            ->whereNotNull('fecha_nacimiento')
            ->get();

        $actualizados = 0;
        $sinCategoria = 0;

        foreach ($jugadores as $jugador) {
            try {
                // Obtener la clave de categoría según fecha de nacimiento
                $claveCat = $this->getClaveCategoriaPorFechaNacimiento($jugador->fecha_nacimiento);

                if (!$claveCat) {
                    // Jugador mayor de 18 años o fecha inválida
                    $sinCategoria++;
                    continue;
                }

                // Si el jugador tiene club, buscar categoría del club
                $categoriasDisponibles = $todasCategorias;
                if ($jugador->club_id) {
                    $idsCategoriasClub = DB::table('clubes_categorias')
                        ->where('club_id', $jugador->club_id)
                        ->pluck('categoria_id')
                        ->toArray();

                    if (!empty($idsCategoriasClub)) {
                        $categoriasDisponibles = $todasCategorias->whereIn('id', $idsCategoriasClub);
                    }
                }

                // Buscar categoría que coincida con la clave
                $categoriaId = $this->findCategoriaIdPorClave($categoriasDisponibles, $claveCat);

                // Si no se encontró en el club, buscar en todas
                if (!$categoriaId && $jugador->club_id) {
                    $categoriaId = $this->findCategoriaIdPorClave($todasCategorias, $claveCat);
                }

                if ($categoriaId && $jugador->categoria_id != $categoriaId) {
                    DB::table('jugadores')
                        ->where('id', $jugador->id)
                        ->update(['categoria_id' => $categoriaId]);
                    $actualizados++;
                }

            } catch (\Exception $e) {
                // Continuar con el siguiente jugador si hay error
                continue;
            }
        }

        // Log para verificar resultados (opcional, se puede ver en la migración)
        echo "\n✓ Categorías ajustadas: {$actualizados} jugadores\n";
        echo "✓ Jugadores sin categoría asignable: {$sinCategoria}\n";
    }

    /**
     * Obtiene la clave de categoría según año de nacimiento (sub8, sub10, etc.)
     */
    private function getClaveCategoriaPorFechaNacimiento(?string $fechaNacimiento): ?string
    {
        if (!$fechaNacimiento) {
            return null;
        }

        try {
            $fecha = Carbon::parse($fechaNacimiento);
            $edad = $fecha->age;
            $añoNacimiento = (int) $fecha->format('Y');
            $añoActual = (int) date('Y');

            // Mayor de 18 años
            if ($edad >= 18) {
                return null;
            }

            // Sub-8: edades 0 a 7 años
            if ($edad <= 7) {
                return 'sub8';
            }

            // Sub-18: nacidos 2009-2010
            if (in_array($añoNacimiento, [$añoActual - 17, $añoActual - 16])) {
                return 'sub18';
            }

            // Sub-16: nacidos 2011-2012
            if (in_array($añoNacimiento, [$añoActual - 15, $añoActual - 14])) {
                return 'sub16';
            }

            // Sub-14: nacidos 2013-2014
            if (in_array($añoNacimiento, [$añoActual - 13, $añoActual - 12])) {
                return 'sub14';
            }

            // Sub-12: nacidos 2015-2016
            if (in_array($añoNacimiento, [$añoActual - 11, $añoActual - 10])) {
                return 'sub12';
            }

            // Sub-10: nacidos 2017-2018
            if (in_array($añoNacimiento, [$añoActual - 9, $añoActual - 8])) {
                return 'sub10';
            }

            // Fallback para casos no cubiertos
            return 'sub8';

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Busca la categoría que coincida con la clave (sub8, sub10, etc.)
     */
    private function findCategoriaIdPorClave($categorias, string $clave): ?int
    {
        // Extraer el número de la clave (sub8 -> 8)
        $numero = (int) preg_replace('/[^0-9]/', '', $clave);

        foreach ($categorias as $cat) {
            $nombreNorm = strtolower(trim($cat->nombre ?? ''));
            // Buscar patrones como: sub8, sub-8, sub_8, sub 8, SUB8, etc.
            if (preg_match('/sub[_\-]?\s*' . $numero . '\b/i', $nombreNorm)) {
                return $cat->id;
            }
        }

        return null;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No se puede revertir automáticamente ya que no guardamos
        // el estado anterior de categoria_id de cada jugador
        echo "\n⚠ Esta migración no se puede revertir automáticamente.\n";
    }
}
