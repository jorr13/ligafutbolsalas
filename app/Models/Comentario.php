<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'autor_id',
        'destinatario_id',
        'parent_id',
        'tipo',
        'contenido',
        'estado',
    ];

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(Arbitros::class, 'destinatario_id');
    }

    public function padre()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function respuestas()
    {
        return $this->hasMany(self::class, 'parent_id')->where('estado', 'aprobado')->orderBy('created_at');
    }

    public function todasLasRespuestas()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('created_at');
    }

    public function scopeAprobados($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeRaiz($query)
    {
        return $query->whereNull('parent_id');
    }
}
