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
        // dd(auth()->user()->id);
        if (!$club) {
            return collect(); // Return an empty collection if no club is found
        }else {
            return self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
                ->where('jugadores.club_id', $club->id)
                ->select('jugadores.*', 'clubes.nombre as club_nombre')
                ->get();
        }
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

    public static function GetjugadoresByClub($clubId, $filters = []) {
        $query = self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->where('jugadores.club_id', $clubId)
            ->select('jugadores.*', 'clubes.nombre as club_nombre', 'categorias.nombre as nombre_categoria');
        
        // Aplicar filtros
        if (!empty($filters['nombre'])) {
            $query->where('jugadores.nombre', 'LIKE', '%' . $filters['nombre'] . '%');
        }
        
        if (!empty($filters['categoria'])) {
            $query->where('categorias.nombre', $filters['categoria']);
        }
        
        if (!empty($filters['status'])) {
            $query->where('jugadores.status', $filters['status']);
        }
        
        return $query->get();
    }

}

