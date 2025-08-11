@extends('layouts.app')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<style>
    #cke_notifications_area_contenido{
       
    }
    .cke_notification_warning {
        display: none !important;
    }
</style>
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h6 class="text-blue-dark mb-2">URL asignada:</h6>
                        <a href="{{ $contenido->url }}" class="text-break">{{ $contenido->url }}</a>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-blue-dark mb-2">Código QR:</h6>
                        <img src="data:image/png;base64,{{ $contenido->qr }}" 
                             alt="QR Code" 
                             class="img-fluid"
                             style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Editar Contenido: {{ $contenido->title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('contenidos.update', ['contenido' => $contenido->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="type" class="form-label text-blue-dark">Tipo</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="0" @if($contenido->tipo=="0") selected @endif>General</option>
                                <option value="1" @if($contenido->tipo=="1") selected @endif>Dependiente</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="eentrenador_id" class="form-label text-blue-dark">Entrenador</label>
                            <select class="form-select" id="entrenador_id" name="eentrenador_id">
                                <option @if($contenido->exhibicion_padre_id == null) selected @endif hidden value="">
                                    Seleccione una exhibición...
                                </option>
                                @foreach ($exhibiciones as $exhibicione)
                                    <option value="{{ $exhibicione->id }}" 
                                            @if($contenido->exhibicion_padre_id == $exhibicione->id) selected @endif>
                                        {{ $exhibicione->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Título</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   required 
                                   value="{{ $contenido->title }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="tipodelcontenido" class="form-label text-blue-dark">Tipo de contenido</label>
                            <select class="form-select" id="tipodelcontenido" name="tipo" required>
                                <option value="0" @if($contenido->tipo_contenido == "0") selected @endif>Texto</option>
                                <option value="1" @if($contenido->tipo_contenido == "1") selected @endif>Video</option>
                                <option value="2" @if($contenido->tipo_contenido == "2") selected @endif>Imágenes</option>
                                <option value="3" @if($contenido->tipo_contenido == "3") selected @endif>Galeria Horizontal (Slider)</option>
                                <option value="4" @if($contenido->tipo_contenido == "4") selected @endif>Galeria Vertical</option>
                                <option value="5" @if($contenido->tipo_contenido == "5") selected @endif>Galeria en acordeon</option>
                            </select>
                        </div>

                        <div class="mb-4" id='micontenido' @if($contenido->tipo_contenido == "0") style="display: block" @else style="display: none" @endif >
                            <label for="contenido" class="form-label text-blue-dark">Contenido</label>
                            <textarea name="contenido" id="contenido" class="form-control" rows="6"placeholder="Ingrese el contenido aquí...">{{ $contenido->contenido }}</textarea>
                        </div>
                        <div class="mb-4" id='mivideo' @if($contenido->tipo_contenido == "1") style="display: block" @else style="display: none" @endif>
                            <label for="contenido" class="form-label text-blue-dark">Videos</label>
                            <input type="file" id="video" name="video" accept="video/*" >
                            <span>Seleccione el nuevo video a editar</span>
                            <br><span style="color:#ff5353;">El nuevo video reemplazara el anterior</span>
                        </div>
                        <div class="mb-4" id='miimagenes' @if($contenido->tipo_contenido == "2") style="display: block" @else style="display: none" @endif>
                            <label for="contenido" class="form-label text-blue-dark">Imagenes</label>
                            <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple>
                            <br><span>Seleccione las nuevas imagenes a editar</span>
                            <br><span style="color:#ff5353;">Las nuevas imagenes seleccionadas seran reemplazadas por las otras</span>
                        </div>
                        <div class="mb-4" id='generarCampos' @if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5") style="display: block" @else style="display: none;" @endif>
                            <label for="contenido" class="form-label text-blue-dark">¿Cuántas imágenes deseas cargar?</label>
                            <input type="number" class="form-control"  id="cantidadImagenes" min="1" max="20" onchange="generarCampos()" 
                            @if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5") value="{{ $contenidoAsociado->count() }}"@endif>
                        </div>
                        <div class="mb-4" id='camposImagenes' @if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5") style="display: block" @else style="display: none;" @endif>
                            @if($contenido->tipo_contenido=="3" || $contenido->tipo_contenido=="4" || $contenido->tipo_contenido=="5")
                                @foreach($contenidoAsociado as $key => $imagenes) 
                                <div>
                                    <h5>Imagen {{ $key+1 }}</h5>
                                    <input type="hidden" value='{{ $imagenes->id }}' name="imagen_id[]">
                                    <input type="text" class="form-control mb-1" name="imagen_titulo[]" placeholder="Título" value='{{ $imagenes->titulo }}'>
                                    <textarea class="form-control mb-1 " id="descripcionimagen{{ $imagenes->id }}" name="imagen_descripcion[]"
                                    placeholder="Descripción">{{ $imagenes->descripcion }}</textarea>
                                    @php
                                        $imagen = trim($imagenes->imagen_url); // Elimina espacios en blanco alrededor de la ruta
                                    @endphp
                                    <div class="row" style="padding-bottom: 15px;">
                                        <div class="col-6">
                                            <img src="{{ asset('storage/imagenes/' . basename($imagenes->imagen_url)) }}" alt="Imagen" style="position: relative;height: auto;width: 200px;">
                                        </div>
                                        <div class="col-6">
                                            <label for="tipodelcontenido" class="form-label text-blue-dark">Desea editar esta imagen?</label>
                                            <select class="form-select inputcambio" id="respuesta{{ $imagenes->id }}" name="respuesta[]" info-att="eldiv{{ $imagenes->id }}">
                                                <option value="0" selected>No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                        <div id="eldiv{{ $imagenes->id }}"></div>
                                    </div>
                                    
                                    {{-- <input type="file" class="form-control mb-1" name="imagen_archivo[]" value='{{ $imagenes->imagen_url }}'> --}}
                                </div>
                                <script>    CKEDITOR.replace('descripcionimagen'+{{ $imagenes->id }});</script>
                                @endforeach
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('contenidos.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#type").change(function(){
        if($(this).val() == "1"){
            $("#elpapahidden").show();
        }else{
            $("#elpapahidden").hide();
        }
    });
    $("#tipodelcontenido").change(function(){
        switch($(this).val()) {
            case '0':
                $("#micontenido").show();
                $("#mivideo").hide();
                $("#miimagenes").hide();
                $("#generarCampos").hide();
                $('#cantidadImagenes').val('1');
            break;
            case '1':
                $("#micontenido").hide();
                $("#mivideo").show();
                $("#miimagenes").hide();
                $("#generarCampos").hide();
                $('#cantidadImagenes').val('1');
            break;
            case '2':
                $("#micontenido").hide();
                $("#mivideo").hide();
                $("#miimagenes").show();
                $("#generarCampos").hide();
                $('#camposImagenes').html('');
                $('#cantidadImagenes').val('1');
            break;
            case '3':
                $("#micontenido").hide();
                $("#mivideo").hide();
                $("#miimagenes").hide();
                $("#generarCampos").show();
            break;
            case '4':
                $("#micontenido").hide();
                $("#mivideo").hide();
                $("#miimagenes").hide();
                $("#generarCampos").show();
            break;
            case '5':
                $("#micontenido").hide();
                $("#mivideo").hide();
                $("#miimagenes").hide();
                $("#generarCampos").show();
            break;
        }

    });
    function generarCampos() {
        const cantidad = document.getElementById('cantidadImagenes').value;
        const contenedor = document.getElementById('camposImagenes');
        contenedor.innerHTML = ''; // Limpiar campos anteriores

        for (let i = 1; i <= cantidad; i++) {

            contenedor.innerHTML += `
                <div>
                    <h5>Imagen ${i}</h5>
                    <input type="text" class="form-control mb-1" name="imagen_titulo[]" placeholder="Título">
                    <textarea class="form-control mb-1" id="descripcionimagen${i}" name="imagen_descripcion[]" 
                    placeholder="Descripción"></textarea>
                    <input type="file" class="form-control mb-1" name="imagen_archivo[]">
                </div>
            `;
        }
        for (let i = 1; i <= cantidad; i++) {
            CKEDITOR.replace('descripcionimagen'+i);
        }
        $("#camposImagenes").show();
    }
    $(".inputcambio").change(function(){
        let elcontenedor = $(this).attr('info-att');
        // let contenedor = document.getElementById();
        if($(this).val() == "0"){
            $('#'+elcontenedor).html('');
        }else{
            $('#'+elcontenedor).html('<input type="file" class="form-control mb-1" name="imagen_archivo[]">');
        }
    });
    CKEDITOR.replace('contenido');


</script>

@endsection
