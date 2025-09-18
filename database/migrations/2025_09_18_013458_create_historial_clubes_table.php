<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialClubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_clubes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->string('accion'); // 'creacion', 'modificacion', 'jugador_ingreso', 'jugador_salida', 'entrenador_asignado', 'entrenador_removido', 'categoria_asignada', 'categoria_removida'
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('jugador_id')->nullable(); // Para acciones relacionadas con jugadores
            $table->unsignedBigInteger('entrenador_id')->nullable(); // Para acciones relacionadas con entrenadores
            $table->unsignedBigInteger('categoria_id')->nullable(); // Para acciones relacionadas con categorías
            $table->unsignedBigInteger('club_relacionado_id')->nullable(); // Para transferencias entre clubes
            $table->string('campo_modificado')->nullable(); // Para registrar qué campo se editó
            $table->text('valor_anterior')->nullable(); // Valor antes de la modificación
            $table->text('valor_nuevo')->nullable(); // Valor después de la modificación
            $table->unsignedBigInteger('usuario_id'); // Usuario que realizó la acción
            $table->timestamp('fecha_accion')->useCurrent();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('club_id')->references('id')->on('clubes')->onDelete('cascade');
            $table->foreign('jugador_id')->references('id')->on('jugadores')->onDelete('set null');
            $table->foreign('entrenador_id')->references('id')->on('entrenadores')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('club_relacionado_id')->references('id')->on('clubes')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            // Índices para mejorar rendimiento
            $table->index(['club_id', 'fecha_accion']);
            $table->index(['accion', 'fecha_accion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_clubes');
    }
}