<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clubes;

class Jugadores extends Model
{
 use HasFactory;
    protected $table = 'jugadores';
    protected $fillable = ['nombre','cedula','telefono','direccion',
        'foto_carnet','foto_identificacion','archivo_cv',
        'user_id','club_id','status',
        'email',
        'numero_dorsal',
        'edad',
        'fecha_nacimiento',
        'tipo_sangre',
        'observacion',
        'foto_identificacion',
        'nombre_representante',
        'cedula_representante',
        'telefono_representante',
        'categoria_id'
    ];

    public static function Getjugadores() {
        $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        return self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->where('jugadores.club_id', $club->id)
            ->select('jugadores.*', 'clubes.nombre as club_nombre')
            ->get();
    }
    public static function GetjugadoresPending() {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        return self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->where('jugadores.status', 'pendiente')
            ->select('jugadores.*', 'clubes.nombre as club_nombre')
            ->get();
    }
    public static function GetjugadoresPendingCount() {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        return self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->where('jugadores.status', 'pendiente')
            ->select('jugadores.*', 'clubes.nombre as club_nombre')
            ->count();
    }

}

