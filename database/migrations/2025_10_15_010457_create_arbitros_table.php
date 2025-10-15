<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArbitrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbitros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('cedula')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->longText('foto_carnet')->nullable();
            $table->longText('foto_cedula')->nullable();
            $table->longText('archivo_cv')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('estatus')->default('activo');
            $table->timestamps();
            
            // Clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arbitros');
    }
}
