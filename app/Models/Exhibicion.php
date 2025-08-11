<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibicion extends Model
{
    use HasFactory;
    protected $table = 'exhibiciones';
    protected $fillable = [
        'title','descrip_url','url','logo','qr','estatus'
    ];
}
