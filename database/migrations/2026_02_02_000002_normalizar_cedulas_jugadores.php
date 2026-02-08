<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizarCedulasJugadores extends Migration
{
    /**
     * Run the migrations.
     * Normaliza las cédulas de jugadores según las reglas:
     * - Si empieza con número → agregar "V-"
     * - Si empieza con V, E, F, P → agregar "-" entre letra y número
     * - Si empieza con otra letra → sin cambios
     *
     * @return void
     */
    public function up()
    {
        $jugadores = DB::table('jugadores')->whereNotNull('cedula')->where('cedula', '!=', '')->get();

        foreach ($jugadores as $jugador) {
            $cedula = trim($jugador->cedula);
            $nuevaCedula = $cedula;

            // Caso 1: Si empieza con un número → agregar "V-"
            if (preg_match('/^\d/', $cedula)) {
                $nuevaCedula = 'V-' . $cedula;
            }
            // Caso 2: Si empieza con V, E, F o P (sin guión) → agregar "-" entre letra y número
            elseif (preg_match('/^([VvEeFfPp])(\d+.*)$/', $cedula, $matches)) {
                $letra = $matches[1];
                $numero = $matches[2];
                // Solo agregar si no tiene ya el guión
                if (!str_contains(substr($cedula, 1, 2), '-')) {
                    $nuevaCedula = $letra . '-' . $numero;
                }
            }
            // Caso 3: Si empieza con otra letra → dejar sin efecto (no modificar)

            if ($nuevaCedula !== $cedula) {
                $updateData = ['cedula' => $nuevaCedula];
                // Actualizar tipo_identificacion si la cedula normalizada empieza con V, E, F, P
                if (preg_match('/^[VEFP]/i', $nuevaCedula)) {
                    $updateData['tipo_identificacion'] = strtoupper(substr($nuevaCedula, 0, 1));
                }
                DB::table('jugadores')
                    ->where('id', $jugador->id)
                    ->update($updateData);
            }
        }
    }

    /**
     * Reverse the migrations.
     * No se puede revertir automáticamente la normalización.
     *
     * @return void
     */
    public function down()
    {
        // No se puede revertir de forma automática
        // Las cédulas quedarían normalizadas
    }
}
