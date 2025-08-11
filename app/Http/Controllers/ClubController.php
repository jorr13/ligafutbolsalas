<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clubes;
use App\Models\Entrenadores;
use App\Models\Categorias;
use App\Models\ClubesCategorias;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubes = Clubes::select('clubes.*', 'users.name as entrenador_nombre')
            ->leftJoin('users', function($join) {
            $join->on('users.id', '=', 'clubes.entrenador_id')
                 ->where('users.rol_id', '=', 'entrenador');
            })
            ->get();
        // foreach ($clubes as $club) {
        //     $entrenador = Entrenadores::where('id', $club->entrenador_id)->first();
        //     $club->entrenador_id = $entrenador->nombre;
        // }
   
        return view('clubes.index', compact('clubes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('aqui');
        $entrenadores = Entrenadores::where('club_id', null)->get();
        return view('clubes.create', compact('entrenadores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // Manejar el archivo de imagen
        if ($request->hasFile('logo')) {
            // dd('entro');
            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logos', $fileName, 'public');

            // Guardar la URL en la base de datos
            $urlLogo = '/app/public/' . $filePath;
        }
        $qrCodeImage = base64_encode(file_get_contents(storage_path($urlLogo)));
        // dd($qrCodeImage);
        $club = Clubes::create([
            'nombre' => $request->nombre,
            'localidad' => $request->localidad,
            'rif' => $request->rif,
            'entrenador_id' => $request->entrenador_id,
            'logo' => $qrCodeImage,
            'estatus' => 'activo'
        ]);
        $entrenadores = Entrenadores::find($request->entrenador_id);
        $entrenadores->club_id= $club->id;
        $entrenadores->save();
        return redirect()->route('clubes.index')->with('success', 'Club creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Clubes $clubes)
    {
        return view('clubes.show', compact('clubes'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Clubes $clubes, $id)
    {
        $clubes = Clubes::where('id', $id)->first();
        $entrenadores = Entrenadores::all();
        // dd($clubes);
        return view('clubes.edit', compact('clubes', 'entrenadores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clubes $clubes, $id)
    {

        $clubes = Clubes::where('id', $id)->first();
        if ($request->hasFile('logo')) {
            $path = str_replace('/storage/app/', '', $clubes->logo);
            if (Storage::disk('store')->exists($path)) { 
                Storage::disk('store')->delete($path); 
            }
            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logos', $fileName, 'public');

            // Guardar la URL en la base de datos
            $urlLogo = '/storage/app/public/' . $filePath;
        }else{
            $urlLogo = $clubes->logo;
        }   
     
        $qrCodeImage = base64_encode(file_get_contents(storage_path($clubes->logo)));
        // dd($qrCodeImage);
        $clubes->update([
            'nombre' => $request->nombre,
            'logo' => $qrCodeImage,
            'localidad' => $request->localidad,
            'rif' => $request->rif,
            'entrenador_id' => $request->entrenador_id,
        ]);
        $entrenadores = Entrenadores::find($request->entrenador_id);
        $entrenadores->club_id= $id;
        $entrenadores->save();
        return redirect()->route('clubes.index')->with('success', 'Club editada exitosamente.');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clubes $clubes, $id)
    {
        $clubes = Clubes::where('id', $id)->first();
        $path = str_replace('/storage/app/', '', $clubes->logo);
        if (Storage::disk('store')->exists($path)) { 
            Storage::disk('store')->delete($path); 
        }
        $clubes->delete();
    
        return redirect()->route('clubes.index')->with('success', 'Club eliminada exitosamente.');
    }
    public function asingCategoria($id)
    {
        $clubes = Clubes::find($id);
    
        $categoria = Categorias::all();
        $categoriasAsign = ClubesCategorias::select('clubes_categorias.*', 'categorias.nombre as nombre_categoria')
            ->join('categorias', 'clubes_categorias.categoria_id', '=', 'categorias.id')
            ->where('clubes_categorias.club_id', $id)
            ->get();

        // dd($categoriasAsign);
        return view('clubes.asignarcategoria', compact('clubes','categoria','categoriasAsign'));
    }   
    public function asingClubCategoria(Request $request, $id)
    {
        $existe = ClubesCategorias::where('club_id', $id)
        ->where('categoria_id', $request->categorias_id)
        ->count();
        if($existe==0){
            ClubesCategorias::create([
            'club_id' => $id,
            'categoria_id' => $request->categorias_id,
            ]);
        }
        return redirect()->route('clubes.index')->with('success', 'Club Asignada exitosamente.');
    }   
    public function deleteClubCategoria(Request $request)
    {
        // dd($request->id);
        $existe = ClubesCategorias::find($request->id);
        // dd($existe);
        $existe->delete();
        return redirect()->route('clubes.index')->with('success', 'Categoria Eliminada exitosamente.');
    }   
}
