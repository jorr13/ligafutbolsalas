<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugadores;
use App\Models\Clubes;
use App\Models\HistorialJugador;
use App\Models\HistorialClub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferenciaController extends Controller
{
    /**
     * Muestra el formulario de transferencia para un jugador específico
     */
    public function showTransferForm($id)
    {
        $jugador = Jugadores::with(['club', 'categoria'])->findOrFail($id);
        $clubes = Clubes::where('estatus', 'activo')->get();
        
        return view('transferencias.form', compact('jugador', 'clubes'));
    }

    /**
     * Procesa la transferencia del jugador
     */
    public function transferirJugador(Request $request, $id)
    {
        $request->validate([
            'club_nuevo_id' => 'required|exists:clubes,id',
            'descripcion' => 'nullable|string|max:500'
        ]);

        $jugador = Jugadores::findOrFail($id);
        $clubAnteriorId = $jugador->club_id;
        $clubNuevoId = $request->club_nuevo_id;

        // Validar que no se transfiera al mismo club
        if ($clubAnteriorId == $clubNuevoId) {
            return redirect()->back()
                ->withErrors(['club_nuevo_id' => 'El jugador ya pertenece a este club.'])
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Actualizar el club del jugador
            $jugador->update([
                'club_id' => $clubNuevoId,
                'status' => 'activo' // Mantener activo después de transferencia
            ]);

            // Registrar en el historial del jugador
            HistorialJugador::registrarTransferencia(
                $jugador->id,
                $clubAnteriorId,
                $clubNuevoId,
                Auth::id(),
                $request->descripcion
            );

            // Obtener información de los clubes
            $clubAnterior = $clubAnteriorId ? Clubes::find($clubAnteriorId) : null;
            $clubNuevo = Clubes::find($clubNuevoId);

            // Registrar en el historial del club anterior (salida del jugador)
            if ($clubAnterior) {
                $clubAnterior->registrarJugadorSalida(
                    $jugador->id,
                    $clubNuevoId,
                    "Jugador {$jugador->nombre} transferido al club {$clubNuevo->nombre}"
                );
            }

            // Registrar en el historial del club nuevo (ingreso del jugador)
            $clubNuevo->registrarJugadorIngreso(
                $jugador->id,
                "Jugador {$jugador->nombre} transferido desde el club " . ($clubAnterior ? $clubAnterior->nombre : 'Sin club')
            );

            DB::commit();

            return redirect()->route('clubes.index')
                ->with('success', "Jugador {$jugador->nombre} transferido exitosamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Error al procesar la transferencia: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Muestra el historial de transferencias y ediciones de un jugador
     */
    public function mostrarHistorial($id)
    {
        $jugador = Jugadores::with(['club', 'categoria'])->findOrFail($id);
        $historial = HistorialJugador::with(['clubAnterior', 'clubNuevo', 'usuario'])
            ->where('jugador_id', $id)
            ->orderBy('fecha_movimiento', 'desc')
            ->get();

        return view('transferencias.historial', compact('jugador', 'historial'));
    }
}
