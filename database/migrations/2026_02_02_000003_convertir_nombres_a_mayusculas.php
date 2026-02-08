<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertirNombresAMayusculas extends Migration
{
    /**
     * Run the migrations.
     * Convierte todos los campos nombre a mayúsculas en jugadores, entrenadores, clubes y árbitros.
     *
     * @return void
     */
    public function up()
    {
        // Jugadores
        DB::table('jugadores')->whereNotNull('nombre')->update([
            'nombre' => DB::raw('UPPER(nombre)')
        ]);

        // Entrenadores
        DB::table('entrenadores')->whereNotNull('nombre')->update([
            'nombre' => DB::raw('UPPER(nombre)')
        ]);

        // Clubes
        DB::table('clubes')->update([
            'nombre' => DB::raw('UPPER(nombre)')
        ]);

        // Árbitros
        DB::table('arbitros')->whereNotNull('nombre')->update([
            'nombre' => DB::raw('UPPER(nombre)')
        ]);
    }

    /**
     * Reverse the migrations.
     * No se puede revertir automáticamente la conversión a mayúsculas.
     *
     * @return void
     */
    public function down()
    {
        // No se puede revertir de forma automática
    }
}
