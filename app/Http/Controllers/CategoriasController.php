<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorias;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categorias::paginate(10); // Paginación de 10 categorías por página
        return view('categorias.index', compact('categorias'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Categorias::create([
            'nombre' => $request->nombre,
            'estatus' => 'activo'
        ]);
    
        return redirect()->route('categorias.index')->with('success', 'Categoria creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categorias $categorias)
    {
        return view('categorias.show', compact('categorias'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorias $categorias, $id)
    {
   
        $categorias = Categorias::where('id', $id)->first();
            //  dd($categorias->id);
        return view('categorias.edit', compact('categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorias $categorias, $id)
    {
        $categoria = Categorias::where('id', $id)->first();
        $categoria->update([
            'nombre' => $request->nombre,
        ]);
    
        return redirect()->route('categorias.index')->with('success', 'Categoria editada exitosamente.');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorias $categorias, $id)
    {
        $categoria = Categorias::where('id', $id)->first();
        $categoria->delete();
    
        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada exitosamente.');
    }
}
