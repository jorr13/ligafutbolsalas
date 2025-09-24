<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugadores;
use PDF;
use Illuminate\Support\Facades\Auth;

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

        // Generar el PDF
        $pdf = PDF::loadView('carnet.template', compact('jugador'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        // Nombre del archivo
        $nombreArchivo = 'carnet_' . str_replace(' ', '_', $jugador->nombre) . '_' . $jugador->id . '.pdf';

        return $pdf->download($nombreArchivo);
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
