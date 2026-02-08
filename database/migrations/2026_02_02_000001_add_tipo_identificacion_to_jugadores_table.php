<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoIdentificacionToJugadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->char('tipo_identificacion', 1)->default('V')->after('cedula')->comment('V=Venezolano, E=Extranjero, F=?, P=Pasaporte');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn('tipo_identificacion');
        });
    }
}
