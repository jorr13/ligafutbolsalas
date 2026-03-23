<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Unifica valores legacy "inactivo" con "bloqueado".
     */
    public function up(): void
    {
        DB::table('categorias')->where('estatus', 'inactivo')->update(['estatus' => 'bloqueado']);
    }

    public function down(): void
    {
        // No se revierte de forma fiable sin conocer el estado previo por fila.
    }
};
