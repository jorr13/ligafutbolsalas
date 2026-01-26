<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clubes;
use App\Models\Entrenadores;
use App\Models\Categorias;
use App\Models\Jugadores;
use App\Models\ClubesCategorias;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        $query = Clubes::select('clubes.*', 'entrenadores.nombre as entrenador_nombre')
            ->leftJoin('entrenadores', function($join) {
                $join->on('entrenadores.id', '=', 'clubes.entrenador_id');
            });
        
        // Búsqueda global en múltiples campos
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('clubes.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('clubes.localidad', 'LIKE', '%' . $search . '%')
                  ->orWhere('clubes.rif', 'LIKE', '%' . $search . '%')
                  ->orWhere('entrenadores.nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('clubes.estatus', 'LIKE', '%' . $search . '%')
                  ->orWhere('clubes.id', 'LIKE', '%' . $search . '%');
            });
        }
        
        $clubes = $query->paginate(10)->appends($request->query()); // Paginación de 10 clubes por página
        
        return view('clubes.index', compact('clubes', 'search'));
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
         //dd($request);
         $urlLogo = null;

        // Procesar foto carnet
        if ($request->hasFile('logo')) {
            $urlLogo = Storage::disk('storage')->putFile('logos', $request->file('logo'));
        }
        $club = Clubes::create([
            'nombre' => $request->nombre,
            'localidad' => $request->localidad,
            'rif' => $request->rif,
            'entrenador_id' => $request->entrenador_id,
            'logo' => $urlLogo,
            'estatus' => 'activo'
        ]);
        
        if($request->entrenador_id) {
            $entrenadores = Entrenadores::find($request->entrenador_id);
            $entrenadores->club_id = $club->id;
            $entrenadores->save();
            
            // Registrar en el historial del club
            $club->registrarEntrenadorAsignado(
                $request->entrenador_id,
                "Entrenador '{$entrenadores->nombre}' asignado al club"
            );
        }
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
            // Eliminar archivo anterior si existe
            if ($clubes->logo && Storage::disk('storage')->exists($clubes->logo)) {
                Storage::disk('storage')->delete($clubes->logo);
            }
            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = Storage::disk('storage')->putFileAs('logos', $file, $fileName);

            // Guardar la URL en la base de datos
            $urlLogo = $filePath;
        }else{
            $urlLogo = $clubes->logo;
        }   
     
        $clubes->update([
            'nombre' => $request->nombre,
            'logo' => $urlLogo,
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
        // Eliminar archivo asociado
        if ($clubes->logo && Storage::disk('storage')->exists($clubes->logo)) {
            Storage::disk('storage')->delete($clubes->logo);
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
            
            // Registrar en el historial del club
            $club = Clubes::find($id);
            $categoria = Categorias::find($request->categorias_id);
            $club->registrarCategoriaAsignada(
                $request->categorias_id,
                "Categoría '{$categoria->nombre}' asignada al club"
            );
        }
        return redirect()->route('clubes.index')->with('success', 'Club Asignada exitosamente.');
    }   
    public function deleteClubCategoria(Request $request)
    {
        $existe = ClubesCategorias::find($request->id);
        
        if($existe) {
            // Registrar en el historial del club antes de eliminar
            $club = Clubes::find($existe->club_id);
            $categoria = Categorias::find($existe->categoria_id);
            $club->registrarCategoriaRemovida(
                $existe->categoria_id,
                "Categoría '{$categoria->nombre}' removida del club"
            );
            
            $existe->delete();
        }
        
        return redirect()->route('clubes.index')->with('success', 'Categoria Eliminada exitosamente.');
    }   
    public function verJugadores($id)
    {
        $club = Clubes::find($id);
        $jugadores = Jugadores::select('jugadores.*', 'categorias.nombre as nombre_categoria')
            ->leftJoin('categorias', 'jugadores.categoria_id', '=', 'categorias.id')
            ->where('jugadores.club_id', $id)
            ->get();
        
        // Obtener categorías únicas para el filtro
        $categorias = Categorias::select('categorias.*')
            ->join('jugadores', 'categorias.id', '=', 'jugadores.categoria_id')
            ->where('jugadores.club_id', $id)
            ->distinct()
            ->get();
        
        //dd($jugadores);
        return view('clubes.jugadores', compact('jugadores', 'club', 'categorias'));
    }

}
