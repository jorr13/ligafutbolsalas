<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('destinatario_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('tipo', ['positivo', 'negativo']);
            $table->text('contenido');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->timestamps();

            $table->foreign('autor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('destinatario_id')->references('id')->on('entrenadores')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comentarios')->onDelete('cascade');
            $table->index(['destinatario_id', 'estado']);
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
