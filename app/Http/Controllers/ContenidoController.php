<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenido;
use App\Models\Exhibicion;
use App\Models\ContenidoImagenes;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
 use Illuminate\Support\Facades\Storage;
class ContenidoController extends Controller
{
    public function index()
    {
        $contenidos = Contenido::all();
        return view('contenidos.index', compact('contenidos'));
    }

    public function create()
    {
        $exhibiciones = Exhibicion::all();
        return view('contenidos.create', compact('exhibiciones'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $ultimoRegistro = Contenido::latest('id')->first();
       
        if($ultimoRegistro==null){
            $ultimoRegistro =1;
        }else{
            $ultimoRegistro = intval($ultimoRegistro->id)+1;
        }
        switch ($request->tipo) {
            case "0":
                $elcontenido = $request->contenido;
            break;
            case "1":
                $video = $request->file('video');
                $fileName = time() .$video->getClientOriginalName();
                    
                $filePath = $video->storeAs('videos', $fileName, 'public');
                $elcontenido = '/app/public/' . $filePath;
                break;
            case "2":
                $imagenes = $request->file('imagenes');
                $urlLogo ='';
                foreach ($imagenes as $file) {
                    $fileName = time().$file->getClientOriginalName();
                    $filePath = $file->storeAs('imagenes', $fileName, 'public');
                    if($urlLogo==''){
                        $urlLogo ='/app/public/' . $filePath;
                    }else{
                        $urlLogo = $urlLogo.'||/app/public/' . $filePath;
                    }
                }
                $elcontenido = $urlLogo;
            break;
            default:
            $elcontenido = '';
        }
        // dd($urlLogo);
        $urlapp=env('APP_URL').'contenidos/'.$ultimoRegistro;
        // dd($request,$urlapp);
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($urlapp)
            ->build();

        $result->saveToFile(storage_path('app/public/qrs/'.$request->title.'qrcontenido.png'));
        $qrCodeImage = base64_encode(file_get_contents(storage_path('app/public/qrs/'.$request->title.'qrcontenido.png')));
        
        $createContenido = Contenido::create([
            'title' => $request->title,
            'url' => $urlapp,
            'qr' => $qrCodeImage,
            'tipo_contenido' => $request->tipo,
            'contenido' => $elcontenido,
            'descripcion_contenido' => $request->descripcion,
            'tipo' => $request->type,
            'exhibicion_padre_id' => $request->exhibicion_padre_id,
            'estatus' => 1
        ]);

        if ($request->has('imagen_titulo')) {
            foreach ($request->imagen_titulo as $key => $titulo) {
                $imagen = new ContenidoImagenes();
                $imagen->contenido_id = $createContenido->id;
                $imagen->titulo = $titulo;
                $imagen->descripcion = $request->imagen_descripcion[$key];
                
                // Guardar la imagen en el sistema de archivos
                if ($request->hasFile('imagen_archivo')) {
                    $archivo = $request->file('imagen_archivo')[$key];
                    $ruta = $archivo->store('public/imagenes');
                    $imagen->imagen_url = '/app/'.$ruta;
                }
                
                $imagen->save();
            }
        }

        return redirect()->route('contenidos.index')->with('success', 'Contenido creado exitosamente.');
    }

    public function show(Contenido $contenido)
    {
        return view('contenidos.show', compact('contenido'));
    }

    public function edit(Contenido $contenido)
    {
        $exhibiciones = Exhibicion::all();
        if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5"){
            $contenidoAsociado = ContenidoImagenes::where('contenido_id', $contenido->id)->get();
        }else{
            $contenidoAsociado = '';
        }
        return view('contenidos.edit', compact('contenido','exhibiciones','contenidoAsociado'));
    }

    public function update(Request $request, Contenido $contenido)
    {
        // dd($request);

        $contenido = Contenido::where('id', $contenido->id)->first();
        if($contenido->tipo_contenido=="1"){
            if (Storage::disk('asset')->exists($contenido->contenido)) { 
                Storage::disk('asset')->delete($contenido->contenido); 
            }
        }
        if($contenido->tipo_contenido == "2"){
            foreach(explode('||', $contenido->contenido) as $imagen){
                if (Storage::disk('asset')->exists($imagen)) { 
                    Storage::disk('asset')->delete($imagen); 
                }
            }
      
        }
        if($contenido->tipo_contenido != $request->tipo){
            if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5"){
                $contenidoAsociado = ContenidoImagenes::where('contenido_id', $contenido->id)->get();
                // dd($contenidoAsociado);
                foreach($contenidoAsociado as $asociado){
                    if (Storage::disk('asset')->exists($asociado->imagen_url)) { 
                        Storage::disk('asset')->delete($asociado->imagen_url); 
                    }
                    $asociado->delete();
                }
          
            }
        }

        switch ($request->tipo) {
            case "0":
                $elcontenido = $request->contenido;
                break;
            case "1":
                $video = $request->file('video');
                $fileName = time() .$video->getClientOriginalName();
                    
                $filePath = $video->storeAs('videos', $fileName, 'public');
                $elcontenido = '/app/public/' . $filePath;
                break;
            case "2":
                $imagenes = $request->file('imagenes');
                $urlLogo ='';
                foreach ($imagenes as $file) {
                    $fileName = time() .$file->getClientOriginalName();
                    $filePath = $file->storeAs('imagenes', $fileName, 'public');
                    if($urlLogo==''){
                        $urlLogo ='/app/public/' . $filePath;
                    }else{
                        $urlLogo = $urlLogo.'||/app/public/' . $filePath;
                    }
                }
                $elcontenido = $urlLogo;
                break;
                default:
                $elcontenido = '';
        }


        $contenido->update([
            'title' => $request->title,
            'tipo_contenido' => $request->tipo,
            'contenido' => $elcontenido,
            'tipo' => $request->type,
            'exhibicion_padre_id' => $request->exhibicion_padre_id,
        ]);

        if ($request->has('imagen_titulo')) {
            if($request->imagen_id){
                $conteo=0;
                foreach ($request->imagen_id as $key => $titulo) {
                    
                    $imagen = ContenidoImagenes::find($titulo);
                    // dd($imagen);
                    $imagen->titulo = $request->imagen_titulo[$key];
                    $imagen->descripcion = $request->imagen_descripcion[$key];
                    if($request->respuesta[$key]=="1"){
                        if (Storage::disk('asset')->exists($imagen->imagen_url)) { 
                            Storage::disk('asset')->delete($imagen->imagen_url); 
                        }
                        $archivo = $request->file('imagen_archivo')[$conteo];
                        $ruta = $archivo->store('public/imagenes');
                        $imagen->imagen_url = '/app/'.$ruta;
                    }
                    $imagen->update();
                }
            }else{
                foreach ($request->imagen_titulo as $key => $titulo) {
                    $imagen = new ContenidoImagenes();
                    $imagen->contenido_id = $contenido->id;
                    $imagen->titulo = $request->imagen_titulo[$key];
                    $imagen->descripcion = $request->imagen_descripcion[$key];
                    
                    // Guardar la imagen en el sistema de archivos
                    if ($request->hasFile('imagen_archivo')) {
                        $archivo = $request->file('imagen_archivo')[$key];
                        $ruta = $archivo->store('public/imagenes');
                        $imagen->imagen_url = '/app/'.$ruta;
                    }
                    
                    $imagen->save();
                }
            }
        }

        return redirect()->route('contenidos.index')->with('success', 'Contenido actualizado exitosamente.');
    }

    public function destroy(Contenido $contenido)
    {
        $contenido = Contenido::where('id', $contenido->id)->first();
        if($contenido->tipo_contenido=="1"){
            if (Storage::disk('asset')->exists($contenido->contenido)) { 
                Storage::disk('asset')->delete($contenido->contenido); 
            }
        }
        if($contenido->tipo_contenido=="2"){
            foreach(explode('||', $contenido->contenido) as $imagen){
                if (Storage::disk('asset')->exists($imagen)) { 
                    Storage::disk('asset')->delete($imagen); 
                }
            }
      
        }
        if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5"){
            $contenidoAsociado = ContenidoImagenes::where('contenido_id', $contenido->id)->get();
            // dd($contenidoAsociado);
            foreach($contenidoAsociado as $asociado){
                if (Storage::disk('asset')->exists($asociado->imagen_url)) { 
                    Storage::disk('asset')->delete($asociado->imagen_url); 
                }
                $asociado->delete();
            }
      
        }

        $contenido->delete();

        return redirect()->route('contenidos.index')->with('success', 'Contenido eliminado exitosamente.');
    }
    public function verContenido($url, $contenido)
    {
        $exhibicion = Exhibicion::where('descrip_url', $url)->first();
        $contenido=Contenido::find($contenido);
        // dd($exhibicion, $contenido);
        return view('contenidos.detallecontenido', compact('exhibicion','contenido'));

    }
    public function verContenidoQr($contenido)
    {
        // dd("cambios");
        $contenido= Contenido::find($contenido);
        if($contenido->exhibicion_padre_id !=null){
            $exhibicion = Exhibicion::where('id', $contenido->exhibicion_padre_id)->first();
        }else{
            $exhibicion = '';
        }
        
        if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5"){
            $contenidoAsociado = ContenidoImagenes::where('contenido_id', $contenido->id)->get();
        }else{
            $contenidoAsociado = '';
        }
        // dd($exhibicion, $contenidoAsociado);
        return view('contenidos.detallecontenido', compact('exhibicion','contenido','contenidoAsociado'));

    }
}
