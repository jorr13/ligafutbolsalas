<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialJugadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_jugadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jugador_id');
            $table->string('tipo_movimiento'); // 'transferencia', 'edicion'
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('club_anterior_id')->nullable();
            $table->unsignedBigInteger('club_nuevo_id')->nullable();
            $table->string('campo_modificado')->nullable(); // Para registrar qué campo se editó
            $table->text('valor_anterior')->nullable(); // Valor antes de la edición
            $table->text('valor_nuevo')->nullable(); // Valor después de la edición
            $table->unsignedBigInteger('usuario_id'); // Administrador que realizó la acción
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('jugador_id')->references('id')->on('jugadores')->onDelete('cascade');
            $table->foreign('club_anterior_id')->references('id')->on('clubes')->onDelete('set null');
            $table->foreign('club_nuevo_id')->references('id')->on('clubes')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_jugadores');
    }
}
