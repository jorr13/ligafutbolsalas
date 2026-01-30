<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clubes;
use App\Models\HistorialJugador;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class Jugadores extends Model
{
 use HasFactory;
    protected $table = 'jugadores';
    protected $fillable = ['nombre','cedula','telefono','direccion',
        'foto_carnet','foto_cedula','foto_identificacion','archivo_cv',
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
        'categoria_id',
        'nivel',
        'qr_code_image',
        'qr_code_url'
    ];

    public static function Getjugadores($search = '') {
        $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
        
        // Verificar que el entrenador existe antes de acceder a sus propiedades
        if (!$entrenador) {
            return self::whereRaw('1 = 0'); // Return empty query builder if no entrenador is found
        }
        
        $club = Clubes::where('entrenador_id', $entrenador->id)->first();
        
        // Verificar que el club existe
        if (!$club) {
            return self::whereRaw('1 = 0'); // Return empty query builder if no club is found
        }
        
        $query = self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->where('jugadores.club_id', $club->id)
            ->select('jugadores.*', 'clubes.nombre as club_nombre', 'categorias.nombre as categoria_nombre');
        
        // Búsqueda global en múltiples campos
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('jugadores.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.cedula', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.email', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.telefono', 'LIKE', '%' . $search . '%')
                  ->orWhere('clubes.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('categorias.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.numero_dorsal', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.nombre_representante', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.cedula_representante', 'LIKE', '%' . $search . '%');
            });
        }
        
        return $query;
    }
    
    public static function GetjugadoresCollection() {
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
    public static function GetjugadoresPending($search = '') {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        $query = self::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->where('jugadores.status', 'pendiente')
            ->select('jugadores.*', 'clubes.nombre as club_nombre', 'categorias.nombre as categoria_nombre');
        
        // Búsqueda global en múltiples campos
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('jugadores.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.cedula', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.email', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.telefono', 'LIKE', '%' . $search . '%')
                  ->orWhere('clubes.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('categorias.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.numero_dorsal', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.nombre_representante', 'LIKE', '%' . $search . '%')
                  ->orWhere('jugadores.cedula_representante', 'LIKE', '%' . $search . '%');
            });
        }
        
        return $query;
    }
    
    public static function GetjugadoresPendingCollection() {
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
        
        return $query;
    }

    // Relaciones
    public function club()
    {
        return $this->belongsTo(Clubes::class, 'club_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    public function historial()
    {
        return $this->hasMany(HistorialJugador::class, 'jugador_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Generar QR Code para el jugador
     */
    public function generarQRCode()
    {
        $urlapp = url("jugador/{$this->id}");
        $title = str_replace(' ', '_', $this->nombre);
        
        // Crear directorio si no existe
        $qrDir = storage_path('app/public/qrs');
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }
        
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($urlapp)
            ->build();
            
        $qrPath = storage_path('app/public/qrs/' . $title . '_qrjugador.png');
        $result->saveToFile($qrPath);
        
        // Convertir a base64
        $qrCodeImage = base64_encode(file_get_contents($qrPath));
        
        // Actualizar el modelo
        $this->update([
            'qr_code_image' => $qrCodeImage,
            'qr_code_url' => $urlapp
        ]);
        
        return $qrCodeImage;
    }

    /**
     * Obtener la imagen QR en base64
     */
    public function getQRCodeImageAttribute($value)
    {
        if (!$value) {
            return $this->generarQRCode();
        }
        return $value;
    }
}

