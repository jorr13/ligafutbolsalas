<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RegistraHistorialClub;

class Clubes extends Model
{
    use HasFactory, RegistraHistorialClub;
    
    protected $table = 'clubes';
    protected $fillable = ['nombre','logo','localidad','rif','entrenador_id','estatus'];

    public function categorias() {
        return $this->belongsToMany(Categorias::class, 'clubes_categorias', 'club_id', 'categoria_id');
    }

    public function entrenadores() {
        return $this->hasMany(Entrenadores::class, 'club_id');
    }

    public function jugadores() {
        return $this->hasMany(Jugadores::class, 'club_id');
    }

    public function jugadoresActivos() {
        return $this->hasMany(Jugadores::class, 'club_id')->where('status', 'activo');
    }

    public function jugadoresPendientes() {
        return $this->hasMany(Jugadores::class, 'club_id')->where('status', 'pendiente');
    }

    public function entrenador() {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

    public function historial() {
        return $this->hasMany(HistorialClub::class, 'club_id')->orderBy('fecha_accion', 'desc');
    }

}