<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenadores extends Model
{
    use HasFactory;
    protected $table = 'entrenadores';
    protected $fillable = ['nombre','cedula','email','telefono','direccion','foto_carnet','foto_cedula','archivo_cv','user_id','club_id','estatus','fecha_fin_sancion'];

    protected $casts = [
        'fecha_fin_sancion' => 'date',
    ];

    /** Guardar nombre en mayúsculas */
    public function setNombreAttribute($value): void
    {
        $this->attributes['nombre'] = $value ? mb_strtoupper($value, 'UTF-8') : $value;
    }

    public function club()
    {
        return $this->belongsTo(Clubes::class, 'club_id');
    }
}