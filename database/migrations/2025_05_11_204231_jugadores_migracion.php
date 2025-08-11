<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JugadoresMigracion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('cedula')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('numero_dorsal')->nullable();
            $table->string('edad')->nullable();
            $table->string('fecha_nacimiento')->nullable();
            $table->string('tipo_sangre')->nullable();
            $table->string('observacion')->nullable();
            $table->longText('foto_carnet')->nullable();
            $table->longText('status')->nullable();
            $table->longText('foto_identificacion')->nullable();
            $table->string('nombre_representante')->nullable();
            $table->string('cedula_representante')->nullable();
            $table->string('telefono_representante')->nullable();
            $table->unsignedBigInteger('club_id')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jugadores');
    }
}
