<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Utilidades compartidas para generación de PDFs de carnet (imágenes en disco → base64 para DomPDF).
 * Las plantillas Blade de cada tipo de carnet son independientes.
 */
class CarnetImagenHelper
{
    public static function convertirImagenABase64(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }
        try {
            if (! Storage::disk('storage')->exists($imagePath)) {
                return null;
            }

            $fullPath = Storage::disk('storage')->path($imagePath);
            $imageData = file_get_contents($fullPath);
            $mime = mime_content_type($fullPath);

            return 'data:'.$mime.';base64,'.base64_encode($imageData);
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function corregirOrientacionImagen(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }
        try {
            if (! Storage::disk('storage')->exists($imagePath)) {
                return null;
            }

            $fullPath = Storage::disk('storage')->path($imagePath);

            if (! extension_loaded('gd')) {
                return null;
            }

            $orientation = 1;
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($fullPath);
                if ($exif && isset($exif['Orientation'])) {
                    $orientation = (int) $exif['Orientation'];
                }
            }

            $imageInfo = @getimagesize($fullPath);
            if (! $imageInfo) {
                return null;
            }

            $mime = $imageInfo['mime'];

            $image = null;
            switch ($mime) {
                case 'image/jpeg':
                    $image = @imagecreatefromjpeg($fullPath);
                    break;
                case 'image/png':
                    $image = @imagecreatefrompng($fullPath);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    break;
                case 'image/gif':
                    $image = @imagecreatefromgif($fullPath);
                    break;
                default:
                    return null;
            }

            if (! $image) {
                return null;
            }

            $rotated = $image;

            switch ($orientation) {
                case 2:
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    $rotated = $image;
                    break;
                case 3:
                    $rotated = imagerotate($image, 180, 0);
                    break;
                case 4:
                    imageflip($image, IMG_FLIP_VERTICAL);
                    $rotated = $image;
                    break;
                case 5:
                    $rotated = imagerotate($image, -90, 0);
                    imageflip($rotated, IMG_FLIP_HORIZONTAL);
                    break;
                case 6:
                    $rotated = imagerotate($image, -90, 0);
                    break;
                case 7:
                    $rotated = imagerotate($image, 90, 0);
                    imageflip($rotated, IMG_FLIP_HORIZONTAL);
                    break;
                case 8:
                    $rotated = imagerotate($image, 90, 0);
                    break;
            }

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

            imagedestroy($image);
            if ($rotated !== $image) {
                imagedestroy($rotated);
            }

            return 'data:'.$mime.';base64,'.base64_encode($imageData);
        } catch (\Exception $e) {
            return null;
        }
    }
}
