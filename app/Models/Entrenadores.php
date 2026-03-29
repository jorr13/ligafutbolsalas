<?php

namespace App\Models;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenadores extends Model
{
    use HasFactory;

    protected $table = 'entrenadores';

    protected $fillable = [
        'nombre', 'cedula', 'email', 'telefono', 'direccion', 'foto_carnet', 'foto_cedula', 'archivo_cv',
        'user_id', 'club_id', 'estatus', 'fecha_fin_sancion',
        'qr_code_image', 'qr_code_url', 'qr_perfil_publico',
    ];

    protected $casts = [
        'fecha_fin_sancion' => 'date',
        'qr_perfil_publico' => 'boolean',
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

    public function rutaArchivoQrEnDisco(?string $nombre = null): string
    {
        $nombre = $nombre ?? $this->nombre;
        $title = str_replace(' ', '_', (string) $nombre);

        return storage_path('app/public/qrs/'.$title.'_qrentrenador.png');
    }

    public function eliminarArchivoQrEnDisco(?string $nombre = null): void
    {
        $path = $this->rutaArchivoQrEnDisco($nombre);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Genera el QR apuntando al perfil público del entrenador (misma URL que el carnet).
     */
    public function generarQRCode()
    {
        $urlapp = url("entrenador/{$this->id}");
        $title = str_replace(' ', '_', $this->nombre);

        $qrDir = storage_path('app/public/qrs');
        if (! file_exists($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        $this->eliminarArchivoQrEnDisco();

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($urlapp)
            ->build();

        $qrPath = storage_path('app/public/qrs/'.$title.'_qrentrenador.png');
        $result->saveToFile($qrPath);

        $qrCodeImage = base64_encode(file_get_contents($qrPath));

        $this->update([
            'qr_code_image' => $qrCodeImage,
            'qr_code_url' => $urlapp,
        ]);

        return $qrCodeImage;
    }

    public function getQRCodeImageAttribute($value)
    {
        if ($value !== null && $value !== '') {
            return $value;
        }

        $publico = array_key_exists('qr_perfil_publico', $this->attributes)
            ? (bool) $this->attributes['qr_perfil_publico']
            : true;

        if (! $publico) {
            return null;
        }

        return $this->generarQRCode();
    }
}
