<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFormativoToNivelEnumInJugadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modificar el enum para incluir 'formativo'
        DB::statement("ALTER TABLE jugadores MODIFY COLUMN nivel ENUM('iniciante', 'formativo', 'elite') DEFAULT 'iniciante'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir el enum a solo 'iniciante' y 'elite'
        // Nota: Si hay registros con 'formativo', estos deberán ser actualizados primero
        DB::statement("ALTER TABLE jugadores MODIFY COLUMN nivel ENUM('iniciante', 'elite') DEFAULT 'iniciante'");
    }
}
