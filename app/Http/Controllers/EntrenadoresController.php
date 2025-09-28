<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrenadores;
use App\Models\Clubes;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EntrenadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entrenadores = Entrenadores::leftJoin('clubes', 'entrenadores.club_id', '=', 'clubes.id')
            ->select('entrenadores.*', 'clubes.nombre as nombre_club')
            ->paginate(10); // Paginación de 10 entrenadores por página
        // dd($entrenadores);

        return view('entrenadores.index', compact('entrenadores'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('entrenadores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'rol_id' => 'entrenador',
            'password' => Hash::make($request->pass),
            'status' => 1,
        ]);

        $entrenadorData = [
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'user_id' => $user->id,
            'estatus' => 'activo'
        ];

        // Manejar foto_carnet
        if ($request->hasFile('foto_carnet')) {
            $fotoCarnetPath = Storage::disk('images')->putFile('entrenadores/fotos_carnet', $request->file('foto_carnet'));
            $entrenadorData['foto_carnet'] = $fotoCarnetPath;
        }

        // Manejar foto_cedula
        if ($request->hasFile('foto_cedula')) {
            $fotoCedulaPath = Storage::disk('images')->putFile('entrenadores/fotos_cedula', $request->file('foto_cedula'));
            $entrenadorData['foto_cedula'] = $fotoCedulaPath;
        }

        // Manejar archivo_cv
        if ($request->hasFile('archivo_cv')) {
            $archivoCvPath = Storage::disk('images')->putFile('entrenadores/archivos_cv', $request->file('archivo_cv'));
            $entrenadorData['archivo_cv'] = $archivoCvPath;
        }

        Entrenadores::create($entrenadorData);
    
        return redirect()->route('entrenadores.index')->with('success', 'Entrenador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Entrenadores $entrenadores)
    {
        return view('entrenadores.show', compact('entrenadores'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrenadores $entrenadores, $id)
    {
   
        $entrenadores = Entrenadores::where('id', $id)->first();
            // dd($entrenadores->id);
        return view('entrenadores.edit', compact('entrenadores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrenadores $entrenadores, $id)
    {
        $entrenador = Entrenadores::where('id', $id)->first();
        $user = User::where('id', $entrenador->user_id)->first();
        
        $user->update([
            'name' => $request->nombre,
            'email' => $request->email,
        ]);

        $entrenadorData = [
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ];

        // Manejar foto_carnet
        if ($request->hasFile('foto_carnet')) {
            // Eliminar archivo anterior si existe
            if ($entrenador->foto_carnet && Storage::disk('images')->exists($entrenador->foto_carnet)) {
                Storage::disk('images')->delete($entrenador->foto_carnet);
            }
            $fotoCarnetPath = Storage::disk('images')->putFile('entrenadores/fotos_carnet', $request->file('foto_carnet'));
            $entrenadorData['foto_carnet'] = $fotoCarnetPath;
        }

        // Manejar foto_cedula
        if ($request->hasFile('foto_cedula')) {
            // Eliminar archivo anterior si existe
            if ($entrenador->foto_cedula && Storage::disk('images')->exists($entrenador->foto_cedula)) {
                Storage::disk('images')->delete($entrenador->foto_cedula);
            }
            $fotoCedulaPath = Storage::disk('images')->putFile('entrenadores/fotos_cedula', $request->file('foto_cedula'));
            $entrenadorData['foto_cedula'] = $fotoCedulaPath;
        }

        // Manejar archivo_cv
        if ($request->hasFile('archivo_cv')) {
            // Eliminar archivo anterior si existe
            if ($entrenador->archivo_cv && Storage::disk('images')->exists($entrenador->archivo_cv)) {
                Storage::disk('images')->delete($entrenador->archivo_cv);
            }
            $archivoCvPath = Storage::disk('images')->putFile('entrenadores/archivos_cv', $request->file('archivo_cv'));
            $entrenadorData['archivo_cv'] = $archivoCvPath;
        }

        $entrenador->update($entrenadorData);
    
        return redirect()->route('entrenadores.index')->with('success', 'Entrenador editado exitosamente.');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrenadores $entrenadores, $id)
    {
        $entrenador = Entrenadores::where('id', $id)->first();
        $user = User::where('id', $entrenador->user_id)->first();
        
        // Eliminar archivos asociados
        if ($entrenador->foto_carnet && Storage::disk('images')->exists($entrenador->foto_carnet)) {
            Storage::disk('images')->delete($entrenador->foto_carnet);
        }
        if ($entrenador->foto_cedula && Storage::disk('images')->exists($entrenador->foto_cedula)) {
            Storage::disk('images')->delete($entrenador->foto_cedula);
        }
        if ($entrenador->archivo_cv && Storage::disk('images')->exists($entrenador->archivo_cv)) {
            Storage::disk('images')->delete($entrenador->archivo_cv);
        }
        
        $entrenador->delete();
        $user->delete();
    
        return redirect()->route('entrenadores.index')->with('success', 'Entrenador eliminado exitosamente.');
    }
}
