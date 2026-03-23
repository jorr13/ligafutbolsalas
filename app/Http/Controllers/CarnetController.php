<?php

namespace App\Http\Controllers;

use App\Models\Jugadores;
use App\Support\CarnetImagenHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarnetController extends Controller
{
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
            $fotoCorregida = CarnetImagenHelper::corregirOrientacionImagen($jugador->foto_carnet);
            if (! $fotoCorregida && Storage::disk('storage')->exists($jugador->foto_carnet)) {
                $fotoCorregida = CarnetImagenHelper::convertirImagenABase64($jugador->foto_carnet);
            }
        }

        $logoCorregido = null;
        if ($jugador->club && $jugador->club->logo) {
            $logoCorregido = CarnetImagenHelper::corregirOrientacionImagen($jugador->club->logo);
            if (! $logoCorregido && Storage::disk('storage')->exists($jugador->club->logo)) {
                $logoCorregido = CarnetImagenHelper::convertirImagenABase64($jugador->club->logo);
            }
        }

        // Pasar las imágenes corregidas a la vista
        $imagenesCorregidas = [
            'foto' => $fotoCorregida,
            'logo' => $logoCorregido
        ];

        try {
            // Generar el PDF con tamaño EXACTO 8cm x 5cm (80mm x 50mm) en horizontal
            // Conversión precisa: 1mm = 2.834645669pt
            // 80mm = 226.7716535pt ≈ 226.77pt (ancho)
            // 50mm = 141.7322835pt ≈ 141.73pt (alto)
            
            $pdf = Pdf::loadView('carnet.template', compact('jugador', 'imagenesCorregidas'))
                ->setPaper('A4', 'portrait') // Hoja base A4 vertical
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Arial',
                    'dpi' => 96, // DPI estándar para impresión precisa (96 o 72)
                    'enable_font_subsetting' => false,
                    'isPhpEnabled' => false,
                    'isJavascriptEnabled' => false,
                    'debugKeepTemp' => false,
                    'debugCss' => false,
                    'debugLayout' => false
                ]);

            // Nombre del archivo
            $nombreArchivo = 'carnet_' . str_replace(' ', '_', $jugador->nombre) . '_' . $jugador->id . '.pdf';

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            Log::error('Error al generar PDF del carnet: ' . $e->getMessage());
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
