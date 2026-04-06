<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'estatus',
        'fecha_fin_sancion',
    ];

    protected $casts = [
        'fecha_fin_sancion' => 'date',
    ];

    /** Guardar nombre en mayúsculas */
    public function setNombreAttribute($value): void
    {
        $this->attributes['nombre'] = $value ? mb_strtoupper($value, 'UTF-8') : $value;
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comentariosRecibidos(): HasMany
    {
        return $this->hasMany(Comentario::class, 'destinatario_id');
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
