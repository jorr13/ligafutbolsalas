<?php

namespace App\Http\Controllers;

use App\Models\Arbitros;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Comentarios aprobados sobre un árbitro seleccionado.
     * Comentario raíz: entrenadores y administrador (hacia el árbitro).
     * Respuestas: entrenadores, árbitros y administrador (pendientes de aprobación salvo admin).
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $arbitroId = $request->get('arbitro_id');

        $arbitros = Arbitros::query()->orderBy('nombre')->get();

        $comentarios = collect();

        if ($arbitroId) {
            $comentarios = Comentario::with(['autor', 'destinatario', 'respuestas.autor'])
                ->raiz()
                ->aprobados()
                ->where('destinatario_id', $arbitroId)
                ->latest()
                ->paginate(15)
                ->appends($request->query());
        }

        $arbitroSeleccionado = $arbitroId ? Arbitros::find($arbitroId) : null;

        $comentariosPendientesCount = 0;
        if (Auth::user()->rol_id === 'administrador') {
            $comentariosPendientesCount = Comentario::pendientes()->count();
        }

        return view('comentarios.index', compact('arbitros', 'comentarios', 'arbitroSeleccionado', 'search', 'comentariosPendientesCount'));
    }

    /**
     * Comentario raíz: entrenador o administrador (sobre un árbitro).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (! in_array($user->rol_id, ['entrenador', 'administrador'])) {
            abort(403, 'Solo los entrenadores pueden iniciar un comentario principal sobre un árbitro. Los árbitros solo pueden responder a comentarios existentes.');
        }

        $request->validate([
            'destinatario_id' => 'required|exists:arbitros,id',
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
     * Responder a un comentario aprobado: entrenador, árbitro o administrador (moderación si no es admin).
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
     * Eliminar comentario o respuesta (solo administrador).
     * Al eliminar un comentario raíz, la BD elimina las respuestas en cascada.
     */
    public function eliminar($id)
    {
        if (Auth::user()->rol_id !== 'administrador') {
            abort(403);
        }

        $comentario = Comentario::findOrFail($id);
        $comentario->delete();

        return redirect()->back()->with('success', __('Comentario eliminado correctamente.'));
    }

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

    public function aprobar($id)
    {
        if (Auth::user()->rol_id !== 'administrador') {
            abort(403);
        }

        $comentario = Comentario::findOrFail($id);
        $comentario->update(['estado' => 'aprobado']);

        return redirect()->back()->with('success', 'Comentario aprobado exitosamente.');
    }

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
