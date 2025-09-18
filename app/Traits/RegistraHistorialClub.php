<?php

namespace App\Traits;

use App\Models\HistorialClub;
use Illuminate\Support\Facades\Auth;

trait RegistraHistorialClub
{
    /**
     * Registra una acción en el historial del club
     */
    protected function registrarHistorial($accion, $datos = [])
    {
        $datos['usuario_id'] = $datos['usuario_id'] ?? Auth::id();
        $datos['fecha_accion'] = $datos['fecha_accion'] ?? now();

        return HistorialClub::create(array_merge([
            'club_id' => $this->id,
            'accion' => $accion,
        ], $datos));
    }

    /**
     * Boot del trait - registra eventos automáticamente
     */
    protected static function bootRegistraHistorialClub()
    {
        // Registrar creación del club
        static::created(function ($club) {
            HistorialClub::registrarCreacion(
                $club->id,
                Auth::id(),
                "Club '{$club->nombre}' creado"
            );
        });

        // Registrar modificaciones del club
        static::updated(function ($club) {
            $original = $club->getOriginal();
            $changes = $club->getChanges();

            foreach ($changes as $field => $newValue) {
                // Excluir campos que no queremos registrar
                if (in_array($field, ['updated_at', 'created_at'])) {
                    continue;
                }

                $oldValue = $original[$field] ?? null;
                
                HistorialClub::registrarModificacion(
                    $club->id,
                    $field,
                    $oldValue,
                    $newValue,
                    Auth::id(),
                    "Campo '{$field}' modificado de '{$oldValue}' a '{$newValue}'"
                );
            }
        });
    }

    /**
     * Método para registrar ingreso de jugador
     */
    public function registrarJugadorIngreso($jugadorId, $descripcion = null)
    {
        return $this->registrarHistorial('jugador_ingreso', [
            'jugador_id' => $jugadorId,
            'descripcion' => $descripcion ?? 'Jugador agregado al club'
        ]);
    }

    /**
     * Método para registrar salida de jugador
     */
    public function registrarJugadorSalida($jugadorId, $clubDestinoId = null, $descripcion = null)
    {
        return $this->registrarHistorial('jugador_salida', [
            'jugador_id' => $jugadorId,
            'club_relacionado_id' => $clubDestinoId,
            'descripcion' => $descripcion ?? ($clubDestinoId ? 'Jugador transferido' : 'Jugador removido del club')
        ]);
    }

    /**
     * Método para registrar asignación de entrenador
     */
    public function registrarEntrenadorAsignado($entrenadorId, $descripcion = null)
    {
        return $this->registrarHistorial('entrenador_asignado', [
            'entrenador_id' => $entrenadorId,
            'descripcion' => $descripcion ?? 'Entrenador asignado al club'
        ]);
    }

    /**
     * Método para registrar remoción de entrenador
     */
    public function registrarEntrenadorRemovido($entrenadorId, $descripcion = null)
    {
        return $this->registrarHistorial('entrenador_removido', [
            'entrenador_id' => $entrenadorId,
            'descripcion' => $descripcion ?? 'Entrenador removido del club'
        ]);
    }

    /**
     * Método para registrar asignación de categoría
     */
    public function registrarCategoriaAsignada($categoriaId, $descripcion = null)
    {
        return $this->registrarHistorial('categoria_asignada', [
            'categoria_id' => $categoriaId,
            'descripcion' => $descripcion ?? 'Categoría asignada al club'
        ]);
    }

    /**
     * Método para registrar remoción de categoría
     */
    public function registrarCategoriaRemovida($categoriaId, $descripcion = null)
    {
        return $this->registrarHistorial('categoria_removida', [
            'categoria_id' => $categoriaId,
            'descripcion' => $descripcion ?? 'Categoría removida del club'
        ]);
    }

    /**
     * Relación con el historial del club
     */
    public function historial()
    {
        return $this->hasMany(HistorialClub::class, 'club_id')->orderBy('fecha_accion', 'desc');
    }
}
