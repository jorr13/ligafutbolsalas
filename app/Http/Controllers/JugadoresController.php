<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugadores;
use App\Models\Clubes;
use App\Models\Categorias;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
 use Illuminate\Support\Facades\Storage;

class JugadoresController extends Controller
{
    public function index()
    {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        $jugadores = Jugadores::Getjugadores(); 
        // dd($jugadores);
        return view('jugadores.index', compact('jugadores'));
    }

    public function create()
    {
        $clubs = Clubes::where('entrenador_id', auth()->user()->id)->first();
        // dd($clubs);
        $jugadores = Jugadores::all();
        $categorias = Categorias::getCategoriasPorClub($clubs->id);
        // dd($categorias);
        return view('jugadores.create', compact('jugadores','categorias'));
    }

    public function store(Request $request)
    {
        $clubs = Clubes::where('entrenador_id', auth()->user()->id)->get();
        // dd($request);
        // $request->validate([
        //     'nombre' => 'required|string|max:255',
        //     'cedula' => 'required|string|max:20',
        //     'telefono' => 'nullable|string|max:15',
        //     'direccion' => 'nullable|string|max:255',
        //     'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'archivo_cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        // ]);
        
        $createJugador = Jugadores::create([

            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            // 'user_id' => auth()->user()->id,
            'club_id' => $clubs->id,
            'foto_carnet' => $request->foto_carnet,
            'foto_identificacion' => $request->foto_cedula,
            // 'archivo_cv' => $request->archivo_cv,
            'status' => 'pendiente',
            'email' => $request->email,
            'numero_dorsal' => $request->numero_dorsal,
            'edad'  => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_sangre' => $request->tipo_sangre,
            'observacion' => $request->observacion,
            'foto_identificacion' => $request->foto_identificacion,
            'nombre_representante' => $request->nombre_representante,
            'cedula_representante' => $request->cedula_representante,
            'telefono_representante' => $request->telefono_representante,
            'categoria_id' => $request->categoria_id,
        
            // 'foto_carnet' => $request->hasFile('foto_carnet') ? $request->file('foto_carnet')->store('public/fotos_carnet') : null,
            // 'foto_cedula' => $request->hasFile('foto_cedula') ? $request->file('foto_cedula')->store('public/fotos_cedula') : null,
            // 'archivo_cv' => $request->hasFile('archivo_cv') ? $request->file('archivo_cv')->store('public/cv') : null,
        ]);

        return redirect()->route('jugadores.index')->with('success', 'Jugador creado exitosamente.');
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
        $jugadores = Jugadores::where('id', $id)->first();
        return view('jugadores.edit', compact('jugadores'));
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
        $jugador->update([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'user_id' => auth()->user()->id,
            'club_id' => $request->club_id,
            'foto_carnet' => $request->foto_carnet,
            'foto_cedula' => $request->foto_cedula,
            'archivo_cv' => $request->archivo_cv,
            'status' => 'pendiente',
            'email' => $request->email,
            'numero_dorsal' => $request->numero_dorsal,
            'edad'  => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_sangre' => $request->tipo_sangre,
            'observacion' => $request->observacion,
            'foto_identificacion' => $request->foto_identificacion,
            'nombre_representante' => $request->nombre_representante,
            'cedula_representante' => $request->cedula_representante,
            'telefono_representante' => $request->telefono_representante,
            'categoria_id' => $request->categoria_id,
        ]);
    
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
        $jugador->delete();
    
        return redirect()->route('jugadores.index')->with('success', 'Jugador eliminado exitosamente.');
    }
    public function aceptarJugador($id)
    {
        // dd($id);
        $jugador = Jugadores::where('id', $id)->first();
        $jugador->update([
            'status' => 'activo',
        ]);
        $jugadores = Jugadores::GetjugadoresPending(); 
        return view('jugadores.index', compact('jugadores'))->with('success', 'Jugador aceptado exitosamente.');
    }
    public function indexAdmin()
    {
        // $club = Clubes::where('entrenador_id', auth()->user()->id)->first();
        $jugadores = Jugadores::GetjugadoresPending(); 
        // $jugadores = Jugadores::Getjugadores(); 
        // dd($jugadores);
        return view('jugadores.index', compact('jugadores'));
    }
}
