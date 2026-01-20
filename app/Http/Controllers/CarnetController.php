<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugadores;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarnetController extends Controller
{
    /**
     * Convertir imagen a base64 sin procesar orientación
     *
     * @param string $imagePath
     * @return string|null Imagen en base64 o null si falla
     */
    private function convertirImagenABase64($imagePath)
    {
        try {
            if (!Storage::disk('storage')->exists($imagePath)) {
                return null;
            }

            $fullPath = Storage::disk('storage')->path($imagePath);
            $imageData = file_get_contents($fullPath);
            $mime = mime_content_type($fullPath);
            
            return 'data:' . $mime . ';base64,' . base64_encode($imageData);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Corregir orientación de imagen basándose en EXIF y forzar corrección
     *
     * @param string $imagePath
     * @return string|null Ruta de la imagen corregida (base64 para el PDF) o null si no se puede corregir
     */
    private function corregirOrientacionImagen($imagePath)
    {
        try {
            // Verificar si la imagen existe
            if (!Storage::disk('storage')->exists($imagePath)) {
                return null;
            }

            // Ruta completa del archivo
            $fullPath = Storage::disk('storage')->path($imagePath);
            
            // Verificar si la extensión GD está disponible
            if (!extension_loaded('gd')) {
                return null;
            }

            // Leer información EXIF si está disponible (solo para JPEG)
            $orientation = 1;
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($fullPath);
                if ($exif && isset($exif['Orientation'])) {
                    $orientation = (int)$exif['Orientation'];
                }
            }

            // Leer la imagen según su tipo
            $imageInfo = @getimagesize($fullPath);
            if (!$imageInfo) {
                return null;
            }

            $mime = $imageInfo['mime'];
            $width = $imageInfo[0];
            $height = $imageInfo[1];
            
            // Crear imagen desde archivo
            $image = null;
            switch ($mime) {
                case 'image/jpeg':
                    $image = @imagecreatefromjpeg($fullPath);
                    break;
                case 'image/png':
                    $image = @imagecreatefrompng($fullPath);
                    // Preservar transparencia para PNG
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    break;
                case 'image/gif':
                    $image = @imagecreatefromgif($fullPath);
                    break;
                default:
                    return null;
            }

            if (!$image) {
                return null;
            }

            // Aplicar rotación según orientación EXIF
            $rotated = $image;
            $needsRotation = false;
            
            switch ($orientation) {
                case 2:
                    // Flip horizontal
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    $rotated = $image;
                    $needsRotation = true;
                    break;
                case 3:
                    // Rotar 180 grados
                    $rotated = imagerotate($image, 180, 0);
                    $needsRotation = true;
                    break;
                case 4:
                    // Flip vertical
                    imageflip($image, IMG_FLIP_VERTICAL);
                    $rotated = $image;
                    $needsRotation = true;
                    break;
                case 5:
                    // Rotar 90 grados y flip horizontal
                    $rotated = imagerotate($image, -90, 0);
                    imageflip($rotated, IMG_FLIP_HORIZONTAL);
                    $needsRotation = true;
                    break;
                case 6:
                    // Rotar -90 grados (o 270 grados)
                    $rotated = imagerotate($image, -90, 0);
                    $needsRotation = true;
                    break;
                case 7:
                    // Rotar 90 grados y flip horizontal
                    $rotated = imagerotate($image, 90, 0);
                    imageflip($rotated, IMG_FLIP_HORIZONTAL);
                    $needsRotation = true;
                    break;
                case 8:
                    // Rotar 90 grados
                    $rotated = imagerotate($image, 90, 0);
                    $needsRotation = true;
                    break;
            }

            // Siempre convertir a base64 para mejor compatibilidad con DomPDF
            // Esto ayuda a que DomPDF renderice la imagen correctamente
            // Convertir a base64 para usar en el PDF
            ob_start();
            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($rotated, null, 90);
                    break;
                case 'image/png':
                    imagealphablending($rotated, false);
                    imagesavealpha($rotated, true);
                    imagepng($rotated, null, 9);
                    break;
                case 'image/gif':
                    imagegif($rotated);
                    break;
            }
            $imageData = ob_get_contents();
            ob_end_clean();

            // Liberar memoria
            imagedestroy($image);
            if ($rotated !== $image) {
                imagedestroy($rotated);
            }

            return 'data:' . $mime . ';base64,' . base64_encode($imageData);
        } catch (\Exception $e) {
            // Si hay algún error, retornar null para usar la imagen original
            return null;
        }
    }

    /**
     * Generar carnet en PDF para un jugador específico
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function generar($id)
    {
        // Verificar que el usuario esté autenticado y sea administrador
        if (!Auth::check() || Auth::user()->rol_id !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta funcionalidad.');
        }

        // Buscar el jugador con sus relaciones
        $jugador = Jugadores::with(['club', 'categoria'])
            ->findOrFail($id);

        // Validar que el jugador tenga los datos necesarios
        if (!$jugador->nombre || !$jugador->cedula) {
            return redirect()->back()
                ->with('error', 'El jugador no tiene los datos completos necesarios para generar el carnet.');
        }

        // Corregir orientación de la foto del jugador si existe
        // Siempre procesar la imagen para convertirla a base64 y mejorar compatibilidad con DomPDF
        $fotoCorregida = null;
        if ($jugador->foto_carnet) {
            $fotoCorregida = $this->corregirOrientacionImagen($jugador->foto_carnet);
            // Si no se pudo corregir, intentar convertir a base64 de todas formas
            if (!$fotoCorregida && Storage::disk('storage')->exists($jugador->foto_carnet)) {
                $fotoCorregida = $this->convertirImagenABase64($jugador->foto_carnet);
            }
        }

        // Corregir orientación del logo del club si existe
        $logoCorregido = null;
        if ($jugador->club && $jugador->club->logo) {
            $logoCorregido = $this->corregirOrientacionImagen($jugador->club->logo);
            // Si no se pudo corregir, intentar convertir a base64 de todas formas
            if (!$logoCorregido && Storage::disk('storage')->exists($jugador->club->logo)) {
                $logoCorregido = $this->convertirImagenABase64($jugador->club->logo);
            }
        }

        // Pasar las imágenes corregidas a la vista
        $imagenesCorregidas = [
            'foto' => $fotoCorregida,
            'logo' => $logoCorregido
        ];

        try {
            // Generar el PDF con tamaño personalizado 80mm x 50mm (ancho x alto) en horizontal
            // Dompdf usa puntos (pt): 1mm ≈ 2.83465pt → 80mm ≈ 226.77pt, 50mm ≈ 141.73pt
            // Para landscape: ancho x alto = 226.77 x 141.73
            $pdf = PDF::loadView('carnet.template', compact('jugador', 'imagenesCorregidas'))
                ->setPaper([0, 0, 226.77, 141.73], 'landscape')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Arial',
                    'margin_top' => 0,
                    'margin_bottom' => 0,
                    'margin_left' => 0,
                    'margin_right' => 0,
                    'page_orientation' => 'landscape',
                    'dpi' => 150,
                    'enable_font_subsetting' => false
                ]);

            // Nombre del archivo
            $nombreArchivo = 'carnet_' . str_replace(' ', '_', $jugador->nombre) . '_' . $jugador->id . '.pdf';

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            \Log::error('Error al generar PDF del carnet: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al generar el carnet. Por favor, intente nuevamente.');
        }
    }

    /**
     * Mostrar vista previa del carnet sin descargar
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function vistaPrevia($id)
    {
        // Verificar que el usuario esté autenticado y sea administrador
        if (!Auth::check() || Auth::user()->rol_id !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta funcionalidad.');
        }

        // Buscar el jugador con sus relaciones
        $jugador = Jugadores::with(['club', 'categoria'])
            ->findOrFail($id);

        return view('carnet.vista-previa', compact('jugador'));
    }
}
