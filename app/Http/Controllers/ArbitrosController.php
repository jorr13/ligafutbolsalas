<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Arbitros;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ArbitrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arbitros = Arbitros::paginate(10); // Paginación de 10 árbitros por página
        //dd($arbitros);
        return view('arbitros.index', compact('arbitros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arbitros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:arbitros,cedula',
            'email' => 'required|email|unique:arbitros,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'pass' => 'required|string|min:6',
            'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'archivo_cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'rol_id' => 'arbitro',
            'password' => Hash::make($request->pass),
            'status' => 1,
        ]);

        $arbitroData = [
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
            $fotoCarnetPath = Storage::disk('storage')->putFile('arbitros/fotos_carnet', $request->file('foto_carnet'));
            $arbitroData['foto_carnet'] = $fotoCarnetPath;
        }

        // Manejar foto_cedula
        if ($request->hasFile('foto_cedula')) {
            $fotoCedulaPath = Storage::disk('storage')->putFile('arbitros/fotos_cedula', $request->file('foto_cedula'));
            $arbitroData['foto_cedula'] = $fotoCedulaPath;
        }

        // Manejar archivo_cv
        if ($request->hasFile('archivo_cv')) {
            $archivoCvPath = Storage::disk('storage')->putFile('arbitros/archivos_cv', $request->file('archivo_cv'));
            $arbitroData['archivo_cv'] = $archivoCvPath;
        }

        Arbitros::create($arbitroData);
    
        return redirect()->route('arbitros.index')->with('success', 'Árbitro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Arbitros $arbitro)
    {
        return view('arbitros.show', compact('arbitro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Arbitros $arbitro)
    {
        return view('arbitros.edit', compact('arbitro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arbitros $arbitro)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:arbitros,cedula,' . $arbitro->id,
            'email' => 'required|email|unique:arbitros,email,' . $arbitro->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'archivo_cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = User::where('id', $arbitro->user_id)->first();
        
        $user->update([
            'name' => $request->nombre,
            'email' => $request->email,
        ]);

        $arbitroData = [
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ];

        // Manejar foto_carnet
        if ($request->hasFile('foto_carnet')) {
            // Eliminar archivo anterior si existe
            if ($arbitro->foto_carnet && Storage::disk('storage')->exists($arbitro->foto_carnet)) {
                Storage::disk('storage')->delete($arbitro->foto_carnet);
            }
            $fotoCarnetPath = Storage::disk('storage')->putFile('arbitros/fotos_carnet', $request->file('foto_carnet'));
            $arbitroData['foto_carnet'] = $fotoCarnetPath;
        }

        // Manejar foto_cedula
        if ($request->hasFile('foto_cedula')) {
            // Eliminar archivo anterior si existe
            if ($arbitro->foto_cedula && Storage::disk('storage')->exists($arbitro->foto_cedula)) {
                Storage::disk('storage')->delete($arbitro->foto_cedula);
            }
            $fotoCedulaPath = Storage::disk('storage')->putFile('arbitros/fotos_cedula', $request->file('foto_cedula'));
            $arbitroData['foto_cedula'] = $fotoCedulaPath;
        }

        // Manejar archivo_cv
        if ($request->hasFile('archivo_cv')) {
            // Eliminar archivo anterior si existe
            if ($arbitro->archivo_cv && Storage::disk('storage')->exists($arbitro->archivo_cv)) {
                Storage::disk('storage')->delete($arbitro->archivo_cv);
            }
            $archivoCvPath = Storage::disk('storage')->putFile('arbitros/archivos_cv', $request->file('archivo_cv'));
            $arbitroData['archivo_cv'] = $archivoCvPath;
        }

        $arbitro->update($arbitroData);
    
        return redirect()->route('arbitros.index')->with('success', 'Árbitro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arbitros $arbitro)
    {
        $user = User::where('id', $arbitro->user_id)->first();
        
        // Eliminar archivos asociados
        if ($arbitro->foto_carnet && Storage::disk('storage')->exists($arbitro->foto_carnet)) {
            Storage::disk('storage')->delete($arbitro->foto_carnet);
        }
        if ($arbitro->foto_cedula && Storage::disk('storage')->exists($arbitro->foto_cedula)) {
            Storage::disk('storage')->delete($arbitro->foto_cedula);
        }
        if ($arbitro->archivo_cv && Storage::disk('storage')->exists($arbitro->archivo_cv)) {
            Storage::disk('storage')->delete($arbitro->archivo_cv);
        }
        
        $arbitro->delete();
        $user->delete();
    
        return redirect()->route('arbitros.index')->with('success', 'Árbitro eliminado exitosamente.');
    }
}
