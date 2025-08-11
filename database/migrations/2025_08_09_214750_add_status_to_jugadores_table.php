<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToJugadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_status_to_jugadores_table.php
    public function up()
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->string('status')->default('activo')->after('club_id');
        });
    }

    public function down()
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
