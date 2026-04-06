<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['destinatario_id']);
        });

        DB::table('comentarios')->delete();

        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('destinatario_id')->references('id')->on('arbitros')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['destinatario_id']);
        });

        DB::table('comentarios')->delete();

        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('destinatario_id')->references('id')->on('entrenadores')->onDelete('cascade');
        });
    }
};
