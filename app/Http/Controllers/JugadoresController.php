<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugadores;
use App\Models\Clubes;
use App\Models\Categorias;
use App\Models\Entrenadores;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
 use Illuminate\Support\Facades\Storage;

class JugadoresController extends Controller
{
    public function index()
    {
        if(auth()->user()->rol_id == 'entrenador'){
        $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
        $club = Clubes::where('entrenador_id', $entrenador->id)->first();

        // Verificar si el entrenador tiene un club asignado
            $hasClub = !is_null($club);
        }else{
            $hasClub = false;
        }
        
        $jugadores = Jugadores::Getjugadores()->paginate(10); // Paginación de 10 jugadores por página
        // dd($jugadores);
        
        return view('jugadores.index', compact('jugadores', 'hasClub', 'club'));
    }

    public function create()
    {
        $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
        $clubs = Clubes::where('entrenador_id', $entrenador->id)->first();
        // Validar que el entrenador tenga un club asignado
        if (!$clubs) {
            return redirect()->route('jugadores.index')
                ->with('error', 'No tienes un club asignado. Contacta al administrador para asignarte a un club antes de crear jugadores.');
        }
        
        $jugadores = Jugadores::all();
        $categorias = Categorias::getCategoriasPorClub($clubs->id);
        // dd($categorias);
        return view('jugadores.create', compact('jugadores','categorias'));
    }

    public function store(Request $request)
    {
        $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
        $clubs = Clubes::where('entrenador_id', $entrenador->id)->first();
        
        // Validar que el entrenador tenga un club asignado
        if (!$clubs) {
            return redirect()->route('jugadores.index')
                ->with('error', 'No tienes un club asignado. Contacta al administrador para asignarte a un club antes de crear jugadores.');
        }
        
        // Validación de campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'numero_dorsal' => 'nullable|string|min:1|max:99',
            'edad' => 'nullable|integer|min:1|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'tipo_sangre' => 'nullable|string|max:10',
            'categoria_id' => 'required|exists:categorias,id',
            'nivel' => 'required|in:iniciante,elite',
            'nombre_representante' => 'nullable|string|max:255',
            'cedula_representante' => 'nullable|string|max:20',
            'telefono_representante' => 'nullable|string|max:15',
            'observacion' => 'nullable|string|max:1000',
            'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_identificacion' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar archivos de fotos
        $fotoCarnetPath = null;
        $fotoCedulaPath = null;
        $fotoIdentificacionPath = null;

        // Procesar foto carnet
        if ($request->hasFile('foto_carnet')) {
            $fotoCarnetPath = Storage::disk('storage')->putFile('jugadores/fotos_carnet', $request->file('foto_carnet'));
        }

        // Procesar foto cédula
        if ($request->hasFile('foto_cedula')) {
            $fotoCedulaPath = Storage::disk('storage')->putFile('jugadores/fotos_cedula', $request->file('foto_cedula'));
        }

        // Procesar foto identificación
        if ($request->hasFile('foto_identificacion')) {
            $fotoIdentificacionPath = Storage::disk('storage')->putFile('jugadores/fotos_identificacion', $request->file('foto_identificacion'));
        }
        
        $createJugador = Jugadores::create([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'club_id' => $clubs->id,
            'foto_carnet' => $fotoCarnetPath,
            'foto_cedula' => $fotoCedulaPath,
            'status' => 'pendiente',
            'email' => $request->email,
            'numero_dorsal' => $request->numero_dorsal,
            'edad'  => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_sangre' => $request->tipo_sangre,
            'observacion' => $request->observacion,
            'foto_identificacion' => $fotoIdentificacionPath,
            'nombre_representante' => $request->nombre_representante,
            'cedula_representante' => $request->cedula_representante,
            'telefono_representante' => $request->telefono_representante,
            'categoria_id' => $request->categoria_id,
            'nivel' => $request->nivel,
        ]);

        // Generar QR Code automáticamente
        $createJugador->generarQRCode();

        return redirect()->route('jugadores.index')->with('success', 'Jugador creado exitosamente, Debe esperar a que el administrador lo acepte.');
    }

 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Jugadores $jugadores)
    {
        return view('jugadores.show', compact('jugadores'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Jugadores $jugadores, $id)
    {
        $jugador = Jugadores::where('id', $id)->first();
        // Validar que el jugador existe y pertenece al entrenador
        if (!$jugador) {
            return redirect()->route('jugadores.index')
                ->with('error', 'Jugador no encontrado.');
        }
        
        $clubs = Clubes::where('entrenador_id', auth()->user()->id)->first();
        
        // Validar que el entrenador tenga un club asignado
        if (!$clubs) {
            return redirect()->route('jugadores.index')
                ->with('error', 'No tienes un club asignado. Contacta al administrador para asignarte a un club antes de editar jugadores.');
        }
        
        // Validar que el jugador pertenece al club del entrenador
        if(auth()->user()->rol_id != 'administrador'){
            if ($jugador->club_id !== $clubs->id) {
                return redirect()->route('jugadores.index')
                    ->with('error', 'No tienes permisos para editar este jugador.');
            }
        }
        $categorias = Categorias::getCategoriasPorClub($clubs->id);
        return view('jugadores.edit', compact('jugador', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jugadores $jugadores, $id)
    {
        $jugador = Jugadores::where('id', $id)->first();
        
        // Validar que el jugador existe
        if (!$jugador) {
            return redirect()->route('jugadores.index')
                ->with('error', 'Jugador no encontrado.');
        }
        
        // Validar permisos: que el jugador pertenezca al club del entrenador
        $clubs = Clubes::where('entrenador_id', auth()->user()->id)->first();
        if (!$clubs || $jugador->club_id !== $clubs->id) {
            return redirect()->route('jugadores.index')
                ->with('error', 'No tienes permisos para actualizar este jugador.');
        }
        
        // Validación de campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'numero_dorsal' => 'nullable|string|min:1|max:99',
            'edad' => 'nullable|integer|min:1|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'tipo_sangre' => 'nullable|string|max:10',
            'categoria_id' => 'required|exists:categorias,id',
            'nivel' => 'required|in:iniciante,elite',
            'nombre_representante' => 'nullable|string|max:255',
            'cedula_representante' => 'nullable|string|max:20',
            'telefono_representante' => 'nullable|string|max:15',
            'observacion' => 'nullable|string|max:1000',
            'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_identificacion' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar archivos de fotos
        $fotoCarnetPath = $jugador->foto_carnet;
        $fotoCedulaPath = $jugador->foto_cedula;
        $fotoIdentificacionPath = $jugador->foto_identificacion;

        // Procesar foto carnet
        if ($request->hasFile('foto_carnet')) {
            // Eliminar archivo anterior si existe
            if ($jugador->foto_carnet && Storage::disk('storage')->exists($jugador->foto_carnet)) {
                Storage::disk('storage')->delete($jugador->foto_carnet);
            }
            $fotoCarnetPath = Storage::disk('storage')->putFile('jugadores/fotos_carnet', $request->file('foto_carnet'));
        }

        // Procesar foto cédula
        if ($request->hasFile('foto_cedula')) {
            // Eliminar archivo anterior si existe
            if ($jugador->foto_cedula && Storage::disk('storage')->exists($jugador->foto_cedula)) {
                Storage::disk('storage')->delete($jugador->foto_cedula);
            }
            $fotoCedulaPath = Storage::disk('storage')->putFile('jugadores/fotos_cedula', $request->file('foto_cedula'));
        }

        // Procesar foto identificación
        if ($request->hasFile('foto_identificacion')) {
            // Eliminar archivo anterior si existe
            if ($jugador->foto_identificacion && Storage::disk('storage')->exists($jugador->foto_identificacion)) {
                Storage::disk('storage')->delete($jugador->foto_identificacion);
            }
            $fotoIdentificacionPath = Storage::disk('storage')->putFile('jugadores/fotos_identificacion', $request->file('foto_identificacion'));
        }

        $jugador->update([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'foto_carnet' => $fotoCarnetPath,
            'foto_cedula' => $fotoCedulaPath,
            'status' => 'pendiente',
            'email' => $request->email,
            'numero_dorsal' => $request->numero_dorsal,
            'edad'  => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_sangre' => $request->tipo_sangre,
            'observacion' => $request->observacion,
            'foto_identificacion' => $fotoIdentificacionPath,
            'nombre_representante' => $request->nombre_representante,
            'cedula_representante' => $request->cedula_representante,
            'telefono_representante' => $request->telefono_representante,
            'categoria_id' => $request->categoria_id,
            'nivel' => $request->nivel,
        ]);
    
        // Regenerar QR Code si es necesario
        $jugador->generarQRCode();
    
        return redirect()->route('jugadores.index')->with('success', 'Jugador editado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jugadores $jugadores, $id)
    {
        $jugador = Jugadores::where('id', $id)->first();
        
        // Validar que el jugador existe
        if (!$jugador) {
            return redirect()->route('jugadores.index')
                ->with('error', 'Jugador no encontrado.');
        }
        
        // Validar permisos: que el jugador pertenezca al club del entrenador
        $clubs = Clubes::where('entrenador_id', auth()->user()->id)->first();
        if (!$clubs || $jugador->club_id !== $clubs->id) {
            return redirect()->route('jugadores.index')
                ->with('error', 'No tienes permisos para eliminar este jugador.');
        }
        
        // Eliminar archivos asociados
        if ($jugador->foto_carnet && Storage::disk('storage')->exists($jugador->foto_carnet)) {
            Storage::disk('storage')->delete($jugador->foto_carnet);
        }
        
        if ($jugador->foto_cedula && Storage::disk('storage')->exists($jugador->foto_cedula)) {
            Storage::disk('storage')->delete($jugador->foto_cedula);
        }
        
        if ($jugador->foto_identificacion && Storage::disk('storage')->exists($jugador->foto_identificacion)) {
            Storage::disk('storage')->delete($jugador->foto_identificacion);
        }
        
        $jugador->delete();
    
        return redirect()->route('jugadores.index')->with('success', 'Jugador eliminado exitosamente.');
    }

    /**
     * Mostrar datos públicos del jugador (acceso por QR)
     */
    public function mostrarJugadorPublico($id)
    {
        $jugador = Jugadores::with(['club', 'categoria'])->find($id);
        
        if (!$jugador) {
            abort(404, 'Jugador no encontrado');
        }
        
        return view('jugadores.publico', compact('jugador'));
    }

    public function aceptarJugador($id)
    {
        // dd($id);
        $jugador = Jugadores::where('id', $id)->first();
        $jugador->update([
            'status' => 'activo',
        ]);
        $jugadores = Jugadores::GetjugadoresPending()->paginate(10); 
        return view('jugadores.index', compact('jugadores'))->with('success', 'Jugador aceptado exitosamente.');
    }

    public function indexAdmin()
    {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        $jugadores = Jugadores::GetjugadoresPending()->paginate(10); 
        // $jugadores = Jugadores::Getjugadores(); 
        // dd($jugadores);
        return view('jugadores.index', compact('jugadores'));
    }

    public function getJugador(Request $request)
    {
        $jugadores = Jugadores::select('jugadores.*', 'categorias.nombre as categoria_nombre', 'clubes.nombre as club_nombre')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->leftJoin('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->where('jugadores.id', $request->id)
            ->first();
        
        if($jugadores){
            // Si el usuario es entrenador, ocultar datos sensibles
            if(auth()->user()->rol_id === 'entrenador'){
                $jugadores->telefono = '[Oculto]';
                $jugadores->email = '[Oculto]';
            }
            
            return response()->json([
                'data' => $jugadores,
                'code' => 200,
                'type' => 'success'
            ]);
        }else{
            return response()->json([
                'message' => "No se encontro el jugador",
                'code' => 404,
                'type' => 'error'
            ]);
        }
    }
    public function getJugadorMio(Request $request)
    {
        $jugadores = Jugadores::select('jugadores.*', 'categorias.nombre as categoria_nombre', 'clubes.nombre as club_nombre')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->leftJoin('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->where('jugadores.id', $request->id)
            ->first();
        
        if($jugadores){
            // Si el usuario es entrenador, ocultar datos sensibles
            /*if(auth()->user()->rol_id === 'entrenador'){
                $jugadores->telefono = '[Oculto]';
                $jugadores->email = '[Oculto]';
            }*/
            
            return response()->json([
                'data' => $jugadores,
                'code' => 200,
                'type' => 'success'
            ]);
        }else{
            return response()->json([
                'message' => "No se encontro el jugador",
                'code' => 404,
                'type' => 'error'
            ]);
        }
    }

    public function filtrarJugadores(Request $request)
    {
        $clubId = $request->club_id;
        $filters = [
            'nombre' => $request->nombre ?? '',
            'categoria' => $request->categoria ?? '',
            'status' => $request->status ?? ''
        ];
        
        $jugadores = Jugadores::GetjugadoresByClub($clubId, $filters)->get();
        
        return response()->json([
            'data' => $jugadores,
            'code' => 200,
            'type' => 'success'
        ]);
    }

    /**
     * Mostrar todos los clubes para el entrenador (solo lectura)
     */
    public function verClub()
    {
        // Verificar que el usuario sea entrenador
       /* if (auth()->user()->rol_id !== 'entrenador') {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }*/

        $clubes = Clubes::with(['categorias'])
            ->leftJoin('users', 'clubes.entrenador_id', '=', 'users.id')
            ->select('clubes.*', 'users.name as entrenador_nombre')
            ->withCount(['jugadoresActivos' => function($query) {
                $query->where('status', 'activo');
            }])
            ->withCount(['jugadoresPendientes' => function($query) {
                $query->where('status', 'pendiente');
            }])
            ->paginate(10);

        return view('clubes.index', compact('clubes'));
    }

    /**
     * Mostrar jugadores de un club específico (solo lectura para entrenadores)
     */
    public function verJugadoresClub($clubId)
    {
        // Verificar que el usuario sea entrenador
       /* if (auth()->user()->rol_id !== 'entrenador') {  
            abort(403, 'No tienes permisos para acceder a esta sección');
        }*/

        $club = Clubes::findOrFail($clubId);
        $categorias = Categorias::getCategoriasPorClub($clubId);
        $jugadores = Jugadores::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->where('jugadores.club_id', $clubId)
            ->select('jugadores.*', 'clubes.nombre as club_nombre', 'categorias.nombre as categoria_nombre')
            ->paginate(10);
        //dd($jugadores);
        return view('jugadores.index-public', compact('jugadores', 'club', 'categorias'));
    }
}
