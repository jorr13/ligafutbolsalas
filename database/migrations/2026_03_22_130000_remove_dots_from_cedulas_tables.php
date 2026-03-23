<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Quita puntos (.) de los campos de cédula en jugadores, entrenadores y árbitros.
     */
    public function up(): void
    {
        foreach (['jugadores', 'entrenadores', 'arbitros'] as $tabla) {
            DB::statement("UPDATE {$tabla} SET cedula = REPLACE(cedula, '.', '') WHERE cedula LIKE '%.%'");
        }

        DB::statement("UPDATE jugadores SET cedula_representante = REPLACE(cedula_representante, '.', '') WHERE cedula_representante LIKE '%.%'");
    }

    public function down(): void
    {
        //
    }
};
