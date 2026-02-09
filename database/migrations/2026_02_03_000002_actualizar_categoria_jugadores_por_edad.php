<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActualizarCategoriaJugadoresPorEdad extends Migration
{
    /**
     * Run the migrations.
     * Evalúa fecha_nacimiento y edad de cada jugador y actualiza categoria_id
     * según la categoría que corresponda a su rango de edad.
     */
    public function up()
    {
        $categoriasConEdad = DB::table('categorias')
            ->whereNotNull('edad_min')
            ->whereNotNull('edad_max')
            ->get();

        $jugadores = DB::table('jugadores')->get();

        foreach ($jugadores as $jugador) {
            $edad = $this->obtenerEdadJugador($jugador);

            if ($edad === null) {
                continue;
            }

            $categoriasQueAplican = $categoriasConEdad->filter(function ($cat) use ($edad) {
                return $edad >= $cat->edad_min && $edad <= $cat->edad_max;
            });

            if ($categoriasQueAplican->isEmpty()) {
                continue;
            }

            $categoriaId = null;
            if ($jugador->club_id) {
                $idsAplican = $categoriasQueAplican->pluck('id')->toArray();
                $delClub = DB::table('clubes_categorias')
                    ->where('club_id', $jugador->club_id)
                    ->whereIn('categoria_id', $idsAplican)
                    ->value('categoria_id');
                if ($delClub) {
                    $categoriaId = $delClub;
                }
            }

            if (!$categoriaId) {
                $actual = $categoriasConEdad->firstWhere('id', $jugador->categoria_id);
                if ($actual && $edad >= $actual->edad_min && $edad <= $actual->edad_max) {
                    continue;
                }
                $categoriaId = $categoriasQueAplican->first()->id;
            }

            if ($jugador->categoria_id != $categoriaId) {
                DB::table('jugadores')->where('id', $jugador->id)->update(['categoria_id' => $categoriaId]);
            }
        }
    }

    /**
     * Obtiene la edad del jugador (prioridad: fecha_nacimiento, luego campo edad).
     */
    private function obtenerEdadJugador($jugador): ?int
    {
        if ($jugador->fecha_nacimiento) {
            try {
                $fecha = Carbon::parse($jugador->fecha_nacimiento);
                return $fecha->age;
            } catch (\Exception $e) {
                // fallback a campo edad
            }
        }

        if ($jugador->edad !== null && $jugador->edad >= 0 && $jugador->edad <= 120) {
            return (int) $jugador->edad;
        }

        return null;
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // No se revierte: los cambios en categoria_id no se pueden deshacer automáticamente
    }
}
