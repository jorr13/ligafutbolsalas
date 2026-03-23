<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Acceso público al perfil al escanear el QR (solo administrador puede desactivarlo).
     */
    public function up(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->boolean('qr_perfil_publico')->default(true)->after('qr_code_url');
        });
    }

    public function down(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn('qr_perfil_publico');
        });
    }
};
