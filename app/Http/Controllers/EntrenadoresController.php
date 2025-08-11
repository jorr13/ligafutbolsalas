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
            ->get();
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

        Entrenadores::create([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'user_id' => $user->id,
            'estatus' => 'activo'
        ]);
    
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
        // dd($entrenador,$user);
        $user->update([
            'name' => $request->nombre,
            'email' => $request->email,
        ]);
        $entrenador->update([
           'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);
    
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
        $user = User::where('id', $id)->first();
        $entrenador->delete();
        $user->delete();
    
        return redirect()->route('entrenadores.index')->with('success', 'Entrenador eliminado exitosamente.');
    }
}
