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
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class JugadoresController extends Controller
{
    /**
     * Calcular la edad basándose en la fecha de nacimiento
     *
     * @param  string|null  $fechaNacimiento
     * @return int|null
     */
    private function calcularEdad($fechaNacimiento)
    {
        if (!$fechaNacimiento) {
            return null;
        }
        
        try {
            $fecha = Carbon::parse($fechaNacimiento);
            $edad = $fecha->age;
            
            // Validar que la edad sea razonable (0-120 años)
            if ($edad >= 0 && $edad <= 120) {
                return $edad;
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    public function index(Request $request)
    {
        $club = null;
        $search = $request->get('search', '');
        
        if(auth()->user()->rol_id == 'entrenador'){
            $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
            $club = Clubes::where('entrenador_id', $entrenador->id)->first();

            // Verificar si el entrenador tiene un club asignado
            $hasClub = !is_null($club);
            
            // Para entrenadores, usar Getjugadores que filtra por club
            $jugadores = Jugadores::Getjugadores($search)->paginate(10)->appends($request->query());
        } else {
            // Para administradores, mostrar todos los jugadores
            $hasClub = false;
            $jugadores = Jugadores::join('clubes', 'jugadores.club_id', '=', 'clubes.id')
                ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
                ->select('jugadores.*', 'clubes.nombre as club_nombre', 'categorias.nombre as categoria_nombre');
            
            // Búsqueda global en múltiples campos para administradores
            if (!empty($search)) {
                $jugadores->where(function($q) use ($search) {
                    $q->where('jugadores.nombre', 'LIKE', '%' . $search . '%')
                      ->orWhere('jugadores.cedula', 'LIKE', '%' . $search . '%')
                      ->orWhere('jugadores.email', 'LIKE', '%' . $search . '%')
                      ->orWhere('jugadores.telefono', 'LIKE', '%' . $search . '%')
                      ->orWhere('clubes.nombre', 'LIKE', '%' . $search . '%')
                      ->orWhere('categorias.nombre', 'LIKE', '%' . $search . '%')
                      ->orWhere('jugadores.numero_dorsal', 'LIKE', '%' . $search . '%')
                      ->orWhere('jugadores.nombre_representante', 'LIKE', '%' . $search . '%')
                      ->orWhere('jugadores.cedula_representante', 'LIKE', '%' . $search . '%');
                });
            }
            
            $jugadores = $jugadores->paginate(10)->appends($request->query());
        }
        
        return view('jugadores.index', compact('jugadores', 'hasClub', 'club', 'search'));
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
      
        $clubs = Clubes::where('id', $entrenador->club_id)->first();
        //dd($entrenador,$clubs);
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
            'email' => [
                'nullable',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value && Jugadores::where('email', $value)->exists()) {
                        $fail('El correo electrónico ya está registrado. Por favor, utiliza otro correo.');
                    }
                },
            ],
            'direccion' => 'nullable|string|max:255',
            'numero_dorsal' => 'nullable|string|min:1|max:99',
            'edad' => 'nullable|integer|min:1|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'tipo_sangre' => 'nullable|string|max:10',
            'categoria_id' => 'required|exists:categorias,id',
            'nivel' => 'required|in:iniciante,formativo,elite',
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
        
        // Calcular edad automáticamente si se proporciona fecha de nacimiento
        $edad = $request->edad;
        if ($request->fecha_nacimiento) {
            $edadCalculada = $this->calcularEdad($request->fecha_nacimiento);
            if ($edadCalculada !== null) {
                $edad = $edadCalculada;
            }
        }
        
        try {
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
                'edad'  => $edad,
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
        } catch (QueryException $e) {
            // Verificar si es un error de email duplicado
            if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'jugadores_email_unique')) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'El correo electrónico ya está registrado. Por favor, utiliza otro correo.']);
            }
            
            // Si es otro error de base de datos, lanzarlo de nuevo
            throw $e;
        }
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
      
        // Validar que el entrenador tenga un club asignado y permisos para editar
        //dd(auth()->user()->rol_id);
        if(auth()->user()->rol_id != 'administrador'){
            $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
      
            $clubs = Clubes::where('id', $entrenador->club_id)->first();
            if (!$clubs || $jugador->club_id !== $clubs->id) {
                return redirect()->route('jugadores.index')
                    ->with('error', 'No tienes permisos para editar este jugador.');
            }
        } else {
            // Si es administrador, obtener el club del jugador
            $clubs = Clubes::find($jugador->club_id);
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
        if(auth()->user()->rol_id == 'arbitro'){
            if (!$clubs || $jugador->club_id !== $clubs->id) {
                return redirect()->route('jugadores.index')
                    ->with('error', 'No tienes permisos para actualizar este jugador.');
            }
        }
        // Validación de campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => [
                'nullable',
                'email',
                'max:255',
                function ($attribute, $value, $fail) use ($jugador) {
                    if ($value && Jugadores::where('email', $value)->where('id', '!=', $jugador->id)->exists()) {
                        $fail('El correo electrónico ya está registrado. Por favor, utiliza otro correo.');
                    }
                },
            ],
            'direccion' => 'nullable|string|max:255',
            'numero_dorsal' => 'nullable|string|min:1|max:99',
            'edad' => 'nullable|integer|min:1|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'tipo_sangre' => 'nullable|string|max:10',
            'categoria_id' => 'required|exists:categorias,id',
            'nivel' => 'required|in:iniciante,formativo,elite',
            'nombre_representante' => 'nullable|string|max:255',
            'cedula_representante' => 'nullable|string|max:20',
            'telefono_representante' => 'nullable|string|max:15',
            'observacion' => 'nullable|string|max:1000',
            'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_identificacion' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar archivos de fotos
        // Se inicializan con los valores actuales para preservarlos si no se envía una nueva imagen
        $fotoCarnetPath = $jugador->foto_carnet;
        $fotoCedulaPath = $jugador->foto_cedula;
        $fotoIdentificacionPath = $jugador->foto_identificacion;

        // Procesar foto carnet - Solo se actualiza si se envía un nuevo archivo
        if ($request->hasFile('foto_carnet')) {
            // Eliminar archivo anterior si existe
            if ($jugador->foto_carnet && Storage::disk('storage')->exists($jugador->foto_carnet)) {
                Storage::disk('storage')->delete($jugador->foto_carnet);
            }
            $fotoCarnetPath = Storage::disk('storage')->putFile('jugadores/fotos_carnet', $request->file('foto_carnet'));
        }

        // Procesar foto cédula - Solo se actualiza si se envía un nuevo archivo
        if ($request->hasFile('foto_cedula')) {
            // Eliminar archivo anterior si existe
            if ($jugador->foto_cedula && Storage::disk('storage')->exists($jugador->foto_cedula)) {
                Storage::disk('storage')->delete($jugador->foto_cedula);
            }
            $fotoCedulaPath = Storage::disk('storage')->putFile('jugadores/fotos_cedula', $request->file('foto_cedula'));
        }

        // Procesar foto identificación - Solo se actualiza si se envía un nuevo archivo
        if ($request->hasFile('foto_identificacion')) {
            // Eliminar archivo anterior si existe
            if ($jugador->foto_identificacion && Storage::disk('storage')->exists($jugador->foto_identificacion)) {
                Storage::disk('storage')->delete($jugador->foto_identificacion);
            }
            $fotoIdentificacionPath = Storage::disk('storage')->putFile('jugadores/fotos_identificacion', $request->file('foto_identificacion'));
        }
        if(isset($request->status)){
            $status = $request->status;
        }else{
            $status = $jugador->status;
        }
        
        // Calcular edad automáticamente si se proporciona fecha de nacimiento
        $edad = $request->edad ?? $jugador->edad;
        if ($request->fecha_nacimiento) {
            $edadCalculada = $this->calcularEdad($request->fecha_nacimiento);
            if ($edadCalculada !== null) {
                $edad = $edadCalculada;
            }
        }
        //dd($edad);
        try {
            $jugador->update([
                'nombre' => $request->nombre,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'foto_carnet' => $fotoCarnetPath,
                'foto_cedula' => $fotoCedulaPath,
                'email' => $request->email,
                'numero_dorsal' => $request->numero_dorsal,
                'edad'  => $edad,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'tipo_sangre' => $request->tipo_sangre,
                'observacion' => $request->observacion,
                'foto_identificacion' => $fotoIdentificacionPath,
                'nombre_representante' => $request->nombre_representante,
                'cedula_representante' => $request->cedula_representante,
                'telefono_representante' => $request->telefono_representante,
                'categoria_id' => $request->categoria_id,
                'nivel' => $request->nivel, 
                'status' => $status,
            ]);
        
            // Regenerar QR Code si es necesario
            //$jugador->generarQRCode();
        
            return redirect()->route('jugadores.index', $jugador->club_id)->with('success', 'Jugador editado exitosamente.');
        } catch (QueryException $e) {
            // Verificar si es un error de email duplicado
            if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'jugadores_email_unique')) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'El correo electrónico ya está registrado. Por favor, utiliza otro correo.']);
            }
            
            // Si es otro error de base de datos, lanzarlo de nuevo
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jugador = Jugadores::where('id', $id)->first();
        
        // Validar que el jugador existe
        if (!$jugador) {
            return redirect()->route('jugadores.index')
                ->with('error', 'Jugador no encontrado.');
        }
        
        // Validar permisos: que el jugador pertenezca al club del entrenador
        $clubs = Clubes::where('entrenador_id', auth()->user()->id)->first();
        if(auth()->user()->rol_id != 'administrador'){
            if (!$clubs || $jugador->club_id !== $clubs->id) {
                return redirect()->route('jugadores.index')
                    ->with('error', 'No tienes permisos para eliminar este jugador.');
            }
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
    
        // Redirigir según el rol del usuario y mantener parámetros de búsqueda
        if(auth()->user()->rol_id == 'administrador') {
            // Obtener parámetros de búsqueda de la petición anterior
            $search = request()->get('search', '');
            $queryParams = [];
            if($search) {
                $queryParams['search'] = $search;
            }
            
            // Verificar si venía de jugadores-pendientes
            $referer = request()->headers->get('referer');
            if($referer && str_contains($referer, 'jugadores-pendientes')) {
                return redirect()->route('jugadores.indexpendientes', $queryParams)->with('success', 'Jugador rechazado exitosamente.');
            }
            return redirect()->route('jugadores.index', $queryParams)->with('success', 'Jugador rechazado exitosamente.');
        }
        
        return redirect()->route('entrenador.clubes.jugadores', $jugador->club_id)->with('success', 'Jugador eliminado exitosamente.');
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

    public function aceptarJugador($id, Request $request)
    {
        // dd($id);
        $jugador = Jugadores::where('id', $id)->first();
        $jugador->update([
            'status' => 'activo',
        ]);
        $search = $request->get('search', '');
        $jugadores = Jugadores::GetjugadoresPending($search)->paginate(10)->appends($request->query()); 
        return view('jugadores.index', compact('jugadores', 'search'))->with('success', 'Jugador aceptado exitosamente.');
    }

    public function indexAdmin(Request $request)
    {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        $hasClub = false;
        $club = null;
        $search = $request->get('search', '');
        $jugadores = Jugadores::GetjugadoresPending($search)->paginate(10)->appends($request->query()); 
        // $jugadores = Jugadores::Getjugadores(); 
        // dd($jugadores);
        return view('jugadores.index', compact('jugadores', 'hasClub', 'club', 'search'));
    }

    public function getJugador(Request $request)
    {
        $jugadores = Jugadores::select('jugadores.*', 'categorias.nombre as categoria_nombre', 'clubes.nombre as club_nombre')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->leftJoin('clubes', 'jugadores.club_id', '=', 'clubes.id')
            ->where('jugadores.id', $request->id)
            ->first();
        
        if($jugadores){
            $rolUsuario = auth()->user()->rol_id ?? null;
            $mostrarContacto = false;
            
            // Aplicar lógica de permisos
            if ($rolUsuario == 'administrador') {
                $mostrarContacto = true;
            } elseif ($rolUsuario == 'entrenador') {
                $entrenador = Entrenadores::where('user_id', auth()->user()->id)->first();
                if ($entrenador && $jugadores->club_id == $entrenador->club_id) {
                    $mostrarContacto = true;
                }
            }
            
            // Si no tiene permisos, ocultar datos sensibles
            if (!$mostrarContacto) {
                $jugadores->telefono = null;
                $jugadores->email = null;
            }
            
            return response()->json([
                'data' => $jugadores,
                'mostrar_contacto' => $mostrarContacto,
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
            ->leftJoin('entrenadores', 'entrenadores.id', '=', 'clubes.entrenador_id')
            ->leftJoin('users', 'users.id', '=', 'entrenadores.user_id')
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
