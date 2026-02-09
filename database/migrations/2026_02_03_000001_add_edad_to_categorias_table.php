<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddEdadToCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     * Añade edad_min y edad_max para restringir categorías según edad del jugador.
     * Mapeo: SUB 8 (6-7), SUB 10 (8-9), SUB 12 (10-11), SUB 14 (12-13), SUB 16 (14-15), SUB 18 (16-17)
     */
    public function up()
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->unsignedTinyInteger('edad_min')->nullable()->after('estatus');
            $table->unsignedTinyInteger('edad_max')->nullable()->after('edad_min');
        });

        // Actualizar categorías existentes por nombre (Sub10, SUB-10, sub 10, etc.)
        // Mapeo: número extraído -> [edad_min, edad_max]
        $mapeoPorNumero = [
            8 => [6, 7],
            10 => [8, 9],
            12 => [10, 11],
            14 => [12, 13],
            16 => [14, 15],
            18 => [16, 17],
        ];

        $categorias = DB::table('categorias')->get();
        foreach ($categorias as $cat) {
            $nombreNorm = strtolower(trim($cat->nombre));
            if (preg_match('/sub[_\-]?\s*(\d+)/', $nombreNorm, $m)) {
                $numero = (int) $m[1];
                if (isset($mapeoPorNumero[$numero])) {
                    $edades = $mapeoPorNumero[$numero];
                    DB::table('categorias')->where('id', $cat->id)->update([
                        'edad_min' => $edades[0],
                        'edad_max' => $edades[1],
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn(['edad_min', 'edad_max']);
        });
    }
}
