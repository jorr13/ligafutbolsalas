<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clubes;
use App\Models\HistorialClub;
use Illuminate\Support\Facades\Auth;

class HistorialClubController extends Controller
{
    /**
     * Muestra el historial completo de un club específico
     */
    public function mostrarHistorial($id)
    {
        $club = Clubes::with(['entrenadores', 'categorias'])->findOrFail($id);
        
        $historial = HistorialClub::with([
            'jugador', 
            'entrenador', 
            'categoria', 
            'clubRelacionado', 
            'usuario'
        ])
        ->where('club_id', $id)
        ->orderBy('fecha_accion', 'desc')
        ->paginate(20);

        return view('clubes.historial', compact('club', 'historial'));
    }

    /**
     * Muestra el historial de todos los clubes (vista administrativa)
     */
    public function mostrarHistorialGeneral(Request $request)
    {
        $query = HistorialClub::with([
            'club',
            'jugador', 
            'entrenador', 
            'categoria', 
            'clubRelacionado', 
            'usuario'
        ]);

        // Filtros
        if ($request->filled('club_id')) {
            $query->where('club_id', $request->club_id);
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_accion', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_accion', '<=', $request->fecha_hasta);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $historial = $query->orderBy('fecha_accion', 'desc')->paginate(25);

        // Datos para los filtros
        $clubes = Clubes::select('id', 'nombre')->orderBy('nombre')->get();
        $usuarios = \App\Models\User::select('id', 'name')->orderBy('name')->get();
        
        $acciones = [
            'creacion' => 'Club creado',
            'modificacion' => 'Club modificado',
            'jugador_ingreso' => 'Jugador agregado',
            'jugador_salida' => 'Jugador removido',
            'entrenador_asignado' => 'Entrenador asignado',
            'entrenador_removido' => 'Entrenador removido',
            'categoria_asignada' => 'Categoría asignada',
            'categoria_removida' => 'Categoría removida'
        ];

        return view('clubes.historial-general', compact('historial', 'clubes', 'usuarios', 'acciones'));
    }

    /**
     * API endpoint para obtener el historial de un club
     */
    public function apiHistorial($id)
    {
        $historial = HistorialClub::with([
            'jugador', 
            'entrenador', 
            'categoria', 
            'clubRelacionado', 
            'usuario'
        ])
        ->where('club_id', $id)
        ->orderBy('fecha_accion', 'desc')
        ->limit(50)
        ->get();

        return response()->json([
            'success' => true,
            'data' => $historial->map(function ($item) {
                return [
                    'id' => $item->id,
                    'accion' => $item->accion,
                    'accion_texto' => $item->accion_texto,
                    'accion_icono' => $item->accion_icono,
                    'descripcion' => $item->descripcion,
                    'fecha_accion' => $item->fecha_accion->format('d/m/Y H:i'),
                    'usuario' => $item->usuario ? $item->usuario->name : 'Sistema',
                    'jugador' => $item->jugador ? $item->jugador->nombre : null,
                    'entrenador' => $item->entrenador ? $item->entrenador->nombre : null,
                    'categoria' => $item->categoria ? $item->categoria->nombre : null,
                    'club_relacionado' => $item->clubRelacionado ? $item->clubRelacionado->nombre : null,
                    'campo_modificado' => $item->campo_modificado,
                    'valor_anterior' => $item->valor_anterior,
                    'valor_nuevo' => $item->valor_nuevo,
                ];
            })
        ]);
    }

    /**
     * Exportar historial a CSV
     */
    public function exportarHistorial($id, Request $request)
    {
        $club = Clubes::findOrFail($id);
        
        $query = HistorialClub::with([
            'jugador', 
            'entrenador', 
            'categoria', 
            'clubRelacionado', 
            'usuario'
        ])->where('club_id', $id);

        // Aplicar filtros si existen
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_accion', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_accion', '<=', $request->fecha_hasta);
        }

        $historial = $query->orderBy('fecha_accion', 'desc')->get();

        $filename = 'historial_club_' . $club->nombre . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($historial) {
            $file = fopen('php://output', 'w');
            
            // Headers del CSV
            fputcsv($file, [
                'Fecha',
                'Acción',
                'Descripción',
                'Usuario',
                'Jugador',
                'Entrenador',
                'Categoría',
                'Club Relacionado',
                'Campo Modificado',
                'Valor Anterior',
                'Valor Nuevo'
            ]);

            foreach ($historial as $item) {
                fputcsv($file, [
                    $item->fecha_accion->format('d/m/Y H:i'),
                    $item->accion_texto,
                    $item->descripcion,
                    $item->usuario ? $item->usuario->name : 'Sistema',
                    $item->jugador ? $item->jugador->nombre : '',
                    $item->entrenador ? $item->entrenador->nombre : '',
                    $item->categoria ? $item->categoria->nombre : '',
                    $item->clubRelacionado ? $item->clubRelacionado->nombre : '',
                    $item->campo_modificado ?: '',
                    $item->valor_anterior ?: '',
                    $item->valor_nuevo ?: ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}