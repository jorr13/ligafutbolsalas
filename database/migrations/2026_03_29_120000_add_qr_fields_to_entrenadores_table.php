<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entrenadores', function (Blueprint $table) {
            $table->text('qr_code_image')->nullable();
            $table->string('qr_code_url')->nullable();
            $table->boolean('qr_perfil_publico')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('entrenadores', function (Blueprint $table) {
            $table->dropColumn(['qr_code_image', 'qr_code_url', 'qr_perfil_publico']);
        });
    }
};
