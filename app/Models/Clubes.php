<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clubes extends Model
{
    use HasFactory;
    protected $table = 'clubes';
    protected $fillable = ['nombre','logo','localidad','rif','entrenador_id','estatus'];

    public function categorias() {
        return $this->belongsToMany(Categorias::class);
    }

    public function entrenadores() {
        return $this->hasMany(Entrenadores::class);
    }

}