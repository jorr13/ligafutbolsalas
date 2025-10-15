<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arbitros extends Model
{
    use HasFactory;
    
    protected $table = 'arbitros';
    
    protected $fillable = [
        'nombre',
        'cedula', 
        'email',
        'telefono',
        'direccion',
        'foto_carnet',
        'foto_cedula',
        'archivo_cv',
        'user_id',
        'estatus'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener árbitros activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'activo');
    }

    /**
     * Obtener árbitros inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estatus', 'inactivo');
    }
}
