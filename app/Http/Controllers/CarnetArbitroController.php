<?php

namespace App\Http\Controllers;

use App\Models\Arbitros;
use App\Support\CarnetImagenHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarnetArbitroController extends Controller
{
    public function generar($id)
    {
        if (! Auth::check() || Auth::user()->rol_id !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta funcionalidad.');
        }

        $arbitro = Arbitros::findOrFail($id);

        if (! $arbitro->nombre || ! $arbitro->cedula) {
            return redirect()->back()
                ->with('error', 'El árbitro no tiene los datos completos necesarios para generar el carnet.');
        }

        $fotoCorregida = null;
        if ($arbitro->foto_carnet) {
            $fotoCorregida = CarnetImagenHelper::corregirOrientacionImagen($arbitro->foto_carnet);
            if (! $fotoCorregida && Storage::disk('storage')->exists($arbitro->foto_carnet)) {
                $fotoCorregida = CarnetImagenHelper::convertirImagenABase64($arbitro->foto_carnet);
            }
        }

        $imagenesCorregidas = [
            'foto' => $fotoCorregida,
        ];

        try {
            $pdf = Pdf::loadView('carnet.template-arbitro', compact('arbitro', 'imagenesCorregidas'))
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

            $nombreArchivo = 'carnet_arbitro_'.str_replace(' ', '_', $arbitro->nombre).'_'.$arbitro->id.'.pdf';

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            Log::error('Error al generar PDF carnet árbitro: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Error al generar el carnet. Por favor, intente nuevamente.');
        }
    }

    public function vistaPrevia($id)
    {
        if (! Auth::check() || Auth::user()->rol_id !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta funcionalidad.');
        }

        $arbitro = Arbitros::findOrFail($id);

        return view('carnet.vista-previa-arbitro', compact('arbitro'));
    }
}
