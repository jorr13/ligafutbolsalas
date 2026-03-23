<?php

namespace App\Services;

use App\Models\Arbitros;
use App\Models\Entrenadores;
use App\Models\User;
use Carbon\Carbon;

class SancionAccesoService
{
    /**
     * Si el usuario no puede entrar por sanción vigente, devuelve el mensaje; si no, null.
     */
    public function mensajeSiBloqueadoPorSancion(User $user): ?string
    {
        if ($user->rol_id === 'entrenador') {
            $e = Entrenadores::where('user_id', $user->id)->first();
            if ($e && $e->estatus === 'sancionado' && $this->sancionVigente($e->fecha_fin_sancion)) {
                return $this->mensaje($e->fecha_fin_sancion);
            }
        }

        if ($user->rol_id === 'arbitro') {
            $a = Arbitros::where('user_id', $user->id)->first();
            if ($a && $a->estatus === 'sancionado' && $this->sancionVigente($a->fecha_fin_sancion)) {
                return $this->mensaje($a->fecha_fin_sancion);
            }
        }

        return null;
    }

    private function sancionVigente($fecha): bool
    {
        if ($fecha === null) {
            return true;
        }

        return Carbon::today()->lte(Carbon::parse($fecha)->startOfDay());
    }

    private function mensaje($fecha): string
    {
        $f = $fecha ? Carbon::parse($fecha)->format('d/m/Y') : '—';

        return "Disculpe usted se encuentra sancionado hasta el {$f}, no podra ingresar al sistema hasta no cumplir la fecha de la sancion";
    }
}
