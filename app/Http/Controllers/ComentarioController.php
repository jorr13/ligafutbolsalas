<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Entrenadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Listado público: comentarios aprobados agrupados por entrenador destinatario.
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $entrenadorId = $request->get('entrenador_id');

        $entrenadores = Entrenadores::leftJoin('clubes', 'entrenadores.club_id', '=', 'clubes.id')
            ->select('entrenadores.*', 'clubes.nombre as nombre_club')
            ->orderBy('entrenadores.nombre')
            ->get();

        $comentarios = collect();

        if ($entrenadorId) {
            $comentarios = Comentario::with(['autor', 'destinatario', 'respuestas.autor'])
                ->raiz()
                ->aprobados()
                ->where('destinatario_id', $entrenadorId)
                ->latest()
                ->paginate(15)
                ->appends($request->query());
        }

        $entrenadorSeleccionado = $entrenadorId ? Entrenadores::with('club')->find($entrenadorId) : null;

        $comentariosPendientesCount = 0;
        if (Auth::user()->rol_id === 'administrador') {
            $comentariosPendientesCount = Comentario::pendientes()->count();
        }

        return view('comentarios.index', compact('entrenadores', 'comentarios', 'entrenadorSeleccionado', 'search', 'comentariosPendientesCount'));
    }

    /**
     * Crear un comentario nuevo (solo entrenador / árbitro).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (! in_array($user->rol_id, ['entrenador', 'arbitro', 'administrador'])) {
            abort(403, 'No tienes permiso para comentar.');
        }

        $request->validate([
            'destinatario_id' => 'required|exists:entrenadores,id',
            'tipo' => 'required|in:positivo,negativo',
            'contenido' => 'required|string|max:1000',
        ]);

        $esAdmin = $user->rol_id === 'administrador';

        Comentario::create([
            'autor_id' => $user->id,
            'destinatario_id' => $request->destinatario_id,
            'tipo' => $request->tipo,
            'contenido' => $request->contenido,
            'estado' => $esAdmin ? 'aprobado' : 'pendiente',
        ]);

        $mensaje = $esAdmin
            ? 'Comentario publicado exitosamente.'
            : 'Comentario enviado. Será visible tras la aprobación del administrador.';

        return redirect()->back()->with('success', $mensaje);
    }

    /**
     * Responder a un comentario (solo entrenador / árbitro, el comentario padre debe estar aprobado).
     */
    public function responder(Request $request, $comentarioId)
    {
        $user = Auth::user();
        if (! in_array($user->rol_id, ['entrenador', 'arbitro', 'administrador'])) {
            abort(403, 'No tienes permiso para responder.');
        }

        $padre = Comentario::where('estado', 'aprobado')->findOrFail($comentarioId);

        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        $esAdmin = $user->rol_id === 'administrador';

        Comentario::create([
            'autor_id' => $user->id,
            'destinatario_id' => $padre->destinatario_id,
            'parent_id' => $padre->id,
            'tipo' => $padre->tipo,
            'contenido' => $request->contenido,
            'estado' => $esAdmin ? 'aprobado' : 'pendiente',
        ]);

        $mensaje = $esAdmin
            ? 'Respuesta publicada exitosamente.'
            : 'Respuesta enviada. Será visible tras la aprobación del administrador.';

        return redirect()->back()->with('success', $mensaje);
    }

    /**
     * Panel de moderación para administradores.
     */
    public function pendientes(Request $request)
    {
        if (Auth::user()->rol_id !== 'administrador') {
            abort(403);
        }

        $comentarios = Comentario::with(['autor', 'destinatario', 'padre'])
            ->pendientes()
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        return view('comentarios.pendientes', compact('comentarios'));
    }

    /**
     * Aprobar un comentario.
     */
    public function aprobar($id)
    {
        if (Auth::user()->rol_id !== 'administrador') {
            abort(403);
        }

        $comentario = Comentario::findOrFail($id);
        $comentario->update(['estado' => 'aprobado']);

        return redirect()->back()->with('success', 'Comentario aprobado exitosamente.');
    }

    /**
     * Rechazar un comentario.
     */
    public function rechazar($id)
    {
        if (Auth::user()->rol_id !== 'administrador') {
            abort(403);
        }

        $comentario = Comentario::findOrFail($id);
        $comentario->update(['estado' => 'rechazado']);

        return redirect()->back()->with('success', 'Comentario rechazado.');
    }
}
