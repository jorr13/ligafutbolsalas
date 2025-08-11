<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exhibicion;
use App\Models\Contenido;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExhibicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exhibiciones = Exhibicion::all();
        // $user = auth()->user();

        // dd($user->rol_id);
        return view('exhibiciones.index', compact('exhibiciones'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $exhibiciones = Exhibicion::where('tipo', '0')->get();
        return view('exhibiciones.create');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        // Generar una URL aleatoria de 15 caracteres única
        do {
            $url = strtolower(Str::random(15));
        } while (Exhibicion::where('url', $url)->exists());
        $ultimoRegistro = Exhibicion::latest('id')->first();
       
        if($ultimoRegistro==null){
            $ultimoRegistro =1;
        }else{
            $ultimoRegistro = intval($ultimoRegistro->id)+1;
        }

        // Manejar el archivo de imagen
        if ($request->hasFile('logo')) {
            // dd('entro');
            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logos', $fileName, 'public');

            // Guardar la URL en la base de datos
            $urlLogo = '/storage/app/public/' . $filePath;
        }
        // $qr = QrCode::size(300)->generate($url);
        $urlapp=env('APP_URL').'exhibicion/'.$url.$ultimoRegistro;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($urlapp)
            ->build();

        $result->saveToFile(storage_path('app/public/qrs/'.$request->title.'qrcode.png'));
        $qrCodeImage = base64_encode(file_get_contents(storage_path('app/public/qrs/'.$request->title.'qrcode.png')));
        
        // $qrCode = new QrCode($url);
        // $qrCode->writeFile(__DIR__.'/qrcode.png');
        // $qrCodeImage = base64_encode(file_get_contents(__DIR__.'/qrcode.png'));

        // dd($qrCode);


        // Guardar la URL en la base de datos
        $urlLogo = '/storage/app/public/' . $filePath;
        $laurl=$url.$ultimoRegistro;
        // dd($laurl);
        Exhibicion::create([
            'title' => $request->title,
            'descrip_url' => $laurl,
            'url' => env('APP_URL').$url.$ultimoRegistro,
            'logo' => $urlLogo,
            'qr' => $qrCodeImage,
            'estatus' => 1
        ]);
    
        return redirect()->route('exhibiciones.index')->with('success', 'Exhibicion creada exitosamente.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exhibicion $exhibicion)
    {
        return view('exhibiciones.show', compact('exhibicion'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exhibicion $exhibicion, $id)
    {
        $exhibicion = Exhibicion::where('id', $id)->first();
        return view('exhibiciones.edit', compact('exhibicion'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exhibicion $exhibicion, $id)
    {
      
        $exhibicion = Exhibicion::where('id', $id)->first();
        //dd($request);
        if ($request->hasFile('logo')) {
            $path = str_replace('/storage/app/', '', $exhibicion->logo);
            if (Storage::disk('store')->exists($path)) { 
                Storage::disk('store')->delete($path); 
            }
            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('logos', $fileName, 'public');

            // Guardar la URL en la base de datos
            $urlLogo = '/storage/app/public/' . $filePath;
        }else{
            $urlLogo = $exhibicion->logo;
        }        

        $exhibicion->update([
            'title' => $request->title,
            'logo' => $urlLogo,
            'estatus' => $request->estatus,
        ]);
    
        return redirect()->route('exhibiciones.index')->with('success', 'Exhibicion actualizada exitosamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exhibicion $exhibicion, $id)
    {

        $exhibicion = Exhibicion::where('id', $id)->first();
        $path = str_replace('/storage/app/', '', $exhibicion->logo);
        if (Storage::disk('store')->exists($path)) { 
            Storage::disk('store')->delete($path); 
        }
        $exhibicion->delete();
        return redirect()->route('exhibiciones.index')->with('success', 'Exhibicion eliminada exitosamente.');
    }    

    public function verExhibicion($url)
    {

        $exhibicion = Exhibicion::where('descrip_url', $url)->first();
        $contenidoGeneral = Contenido::where('tipo', 0)->get();
        $contenidoDependiente = Contenido::where([
            'tipo' => 1,
            'exhibicion_padre_id' => $exhibicion->id,
        ])->get();
        //dd($exhibicion,$contenidoGeneral,$contenidoDependiente);
        return view('exhibiciones.detalleexhibicion', compact('exhibicion','contenidoGeneral','contenidoDependiente'));
    }    

    public function verExhibicionQrs($url)
    {

        $exhibicion = Exhibicion::where('descrip_url', $url)->first();
        $contenidoGeneral = Contenido::where('tipo', 0)->get();
        $contenidoDependiente = Contenido::where([
            'tipo' => 1,
            'exhibicion_padre_id' => $exhibicion->id,
        ])->get();
        // dd($exhibicion,$contenidoGeneral,$contenidoDependiente);
        return view('exhibiciones.detalleexhibicionqr', compact('exhibicion','contenidoGeneral','contenidoDependiente'));
    }    
}
