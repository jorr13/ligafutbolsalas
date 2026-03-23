<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entrenadores', function (Blueprint $table) {
            $table->date('fecha_fin_sancion')->nullable()->after('estatus');
        });
        Schema::table('arbitros', function (Blueprint $table) {
            $table->date('fecha_fin_sancion')->nullable()->after('estatus');
        });
        Schema::table('jugadores', function (Blueprint $table) {
            $table->date('fecha_fin_sancion')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('entrenadores', function (Blueprint $table) {
            $table->dropColumn('fecha_fin_sancion');
        });
        Schema::table('arbitros', function (Blueprint $table) {
            $table->dropColumn('fecha_fin_sancion');
        });
        Schema::table('jugadores', function (Blueprint $table) {
            $table->dropColumn('fecha_fin_sancion');
        });
    }
};
