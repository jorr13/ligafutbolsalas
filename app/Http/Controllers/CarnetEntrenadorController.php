<?php

namespace App\Http\Controllers;

use App\Models\Entrenadores;
use App\Support\CarnetImagenHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarnetEntrenadorController extends Controller
{
    public function generar($id)
    {
        if (! Auth::check() || Auth::user()->rol_id !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta funcionalidad.');
        }

        $entrenador = Entrenadores::with(['club'])->findOrFail($id);

        if (! $entrenador->nombre || ! $entrenador->cedula) {
            return redirect()->back()
                ->with('error', 'El entrenador no tiene los datos completos necesarios para generar el carnet.');
        }

        $fotoCorregida = null;
        if ($entrenador->foto_carnet) {
            $fotoCorregida = CarnetImagenHelper::corregirOrientacionImagen($entrenador->foto_carnet);
            if (! $fotoCorregida && Storage::disk('storage')->exists($entrenador->foto_carnet)) {
                $fotoCorregida = CarnetImagenHelper::convertirImagenABase64($entrenador->foto_carnet);
            }
        }

        $logoCorregido = null;
        if ($entrenador->club && $entrenador->club->logo) {
            $logoCorregido = CarnetImagenHelper::corregirOrientacionImagen($entrenador->club->logo);
            if (! $logoCorregido && Storage::disk('storage')->exists($entrenador->club->logo)) {
                $logoCorregido = CarnetImagenHelper::convertirImagenABase64($entrenador->club->logo);
            }
        }

        $imagenesCorregidas = [
            'foto' => $fotoCorregida,
            'logo' => $logoCorregido,
        ];

        try {
            $pdf = Pdf::loadView('carnet.template-entrenador', compact('entrenador', 'imagenesCorregidas'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Arial',
                    'dpi' => 96,
                    'enable_font_subsetting' => false,
                    'isPhpEnabled' => false,
                    'isJavascriptEnabled' => false,
                    'debugKeepTemp' => false,
                    'debugCss' => false,
                    'debugLayout' => false,
                ]);

            $nombreArchivo = 'carnet_entrenador_'.str_replace(' ', '_', $entrenador->nombre).'_'.$entrenador->id.'.pdf';

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            Log::error('Error al generar PDF carnet entrenador: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Error al generar el carnet. Por favor, intente nuevamente.');
        }
    }

    public function vistaPrevia($id)
    {
        if (! Auth::check() || Auth::user()->rol_id !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta funcionalidad.');
        }

        $entrenador = Entrenadores::with(['club'])->findOrFail($id);

        return view('carnet.vista-previa-entrenador', compact('entrenador'));
    }
}
