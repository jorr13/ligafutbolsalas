<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialClub extends Model
{
    use HasFactory;

    protected $table = 'historial_clubes';

    protected $fillable = [
        'club_id',
        'accion',
        'descripcion',
        'jugador_id',
        'entrenador_id',
        'categoria_id',
        'club_relacionado_id',
        'campo_modificado',
        'valor_anterior',
        'valor_nuevo',
        'usuario_id',
        'fecha_accion'
    ];

    protected $casts = [
        'fecha_accion' => 'datetime',
    ];

    // Relaciones
    public function club()
    {
        return $this->belongsTo(Clubes::class, 'club_id');
    }

    public function jugador()
    {
        return $this->belongsTo(Jugadores::class, 'jugador_id');
    }

    public function entrenador()
    {
        return $this->belongsTo(Entrenadores::class, 'entrenador_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    public function clubRelacionado()
    {
        return $this->belongsTo(Clubes::class, 'club_relacionado_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Métodos estáticos para crear registros de historial
    public static function registrarCreacion($clubId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'creacion',
            'descripcion' => $descripcion ?? 'Club creado',
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarModificacion($clubId, $campoModificado, $valorAnterior, $valorNuevo, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'modificacion',
            'descripcion' => $descripcion ?? "Campo '{$campoModificado}' modificado",
            'campo_modificado' => $campoModificado,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => $valorNuevo,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarJugadorIngreso($clubId, $jugadorId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'jugador_ingreso',
            'descripcion' => $descripcion ?? 'Jugador agregado al club',
            'jugador_id' => $jugadorId,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarJugadorSalida($clubId, $jugadorId, $clubDestinoId = null, $usuarioId = null, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'jugador_salida',
            'descripcion' => $descripcion ?? ($clubDestinoId ? 'Jugador transferido' : 'Jugador removido del club'),
            'jugador_id' => $jugadorId,
            'club_relacionado_id' => $clubDestinoId,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarEntrenadorAsignado($clubId, $entrenadorId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'entrenador_asignado',
            'descripcion' => $descripcion ?? 'Entrenador asignado al club',
            'entrenador_id' => $entrenadorId,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarEntrenadorRemovido($clubId, $entrenadorId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'entrenador_removido',
            'descripcion' => $descripcion ?? 'Entrenador removido del club',
            'entrenador_id' => $entrenadorId,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarCategoriaAsignada($clubId, $categoriaId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'categoria_asignada',
            'descripcion' => $descripcion ?? 'Categoría asignada al club',
            'categoria_id' => $categoriaId,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    public static function registrarCategoriaRemovida($clubId, $categoriaId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'club_id' => $clubId,
            'accion' => 'categoria_removida',
            'descripcion' => $descripcion ?? 'Categoría removida del club',
            'categoria_id' => $categoriaId,
            'usuario_id' => $usuarioId,
            'fecha_accion' => now()
        ]);
    }

    // Método para obtener el texto descriptivo de la acción
    public function getAccionTextoAttribute()
    {
        $acciones = [
            'creacion' => 'Club creado',
            'modificacion' => 'Club modificado',
            'jugador_ingreso' => 'Jugador agregado',
            'jugador_salida' => 'Jugador removido',
            'entrenador_asignado' => 'Entrenador asignado',
            'entrenador_removido' => 'Entrenador removido',
            'categoria_asignada' => 'Categoría asignada',
            'categoria_removida' => 'Categoría removida'
        ];

        return $acciones[$this->accion] ?? $this->accion;
    }

    // Método para obtener el icono de la acción
    public function getAccionIconoAttribute()
    {
        $iconos = [
            'creacion' => 'fas fa-plus-circle text-success',
            'modificacion' => 'fas fa-edit text-warning',
            'jugador_ingreso' => 'fas fa-user-plus text-info',
            'jugador_salida' => 'fas fa-user-minus text-danger',
            'entrenador_asignado' => 'fas fa-user-tie text-primary',
            'entrenador_removido' => 'fas fa-user-times text-danger',
            'categoria_asignada' => 'fas fa-tag text-success',
            'categoria_removida' => 'fas fa-tag text-danger'
        ];

        return $iconos[$this->accion] ?? 'fas fa-circle text-secondary';
    }
}