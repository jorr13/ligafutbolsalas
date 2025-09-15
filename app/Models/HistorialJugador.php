<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialJugador extends Model
{
    use HasFactory;

    protected $table = 'historial_jugadores';

    protected $fillable = [
        'jugador_id',
        'tipo_movimiento',
        'descripcion',
        'club_anterior_id',
        'club_nuevo_id',
        'campo_modificado',
        'valor_anterior',
        'valor_nuevo',
        'usuario_id',
        'fecha_movimiento'
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
    ];

    // Relaciones
    public function jugador()
    {
        return $this->belongsTo(Jugadores::class, 'jugador_id');
    }

    public function clubAnterior()
    {
        return $this->belongsTo(Clubes::class, 'club_anterior_id');
    }

    public function clubNuevo()
    {
        return $this->belongsTo(Clubes::class, 'club_nuevo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Métodos estáticos para crear registros de historial
    public static function registrarTransferencia($jugadorId, $clubAnteriorId, $clubNuevoId, $usuarioId, $descripcion = null)
    {
        return self::create([
            'jugador_id' => $jugadorId,
            'tipo_movimiento' => 'transferencia',
            'descripcion' => $descripcion ?? "Transferencia de jugador",
            'club_anterior_id' => $clubAnteriorId,
            'club_nuevo_id' => $clubNuevoId,
            'usuario_id' => $usuarioId,
            'fecha_movimiento' => now()
        ]);
    }

    public static function registrarEdicion($jugadorId, $campoModificado, $valorAnterior, $valorNuevo, $usuarioId, $descripcion = null)
    {
        return self::create([
            'jugador_id' => $jugadorId,
            'tipo_movimiento' => 'edicion',
            'descripcion' => $descripcion ?? "Edición de campo: {$campoModificado}",
            'campo_modificado' => $campoModificado,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => $valorNuevo,
            'usuario_id' => $usuarioId,
            'fecha_movimiento' => now()
        ]);
    }
}
