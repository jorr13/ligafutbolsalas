@extends('layouts.app')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<style>
    #cke_notifications_area_contenido{
        display: none !important;
    }
    .cke_notification_warning {
        display: none !important;
    }
</style>
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Nuevo Contenido</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('contenidos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="type" class="form-label text-blue-dark">Tipo</label>
                            <select class="form-select" id="type" name="type" required>
                                <option selected hidden value="">Seleccione una opción...</option>
                                <option value="0">General</option>
                                <option value="1">Dependiente</option>
                            </select>
                        </div>
                        
                        <div class="mb-4" id="elpapahidden" style="display: none;">
                            <label for="exhibicion_padre_id" class="form-label text-blue-dark">Exhibición Padre</label>
                            <select class="form-select" id="exhibicion_padre_id" name="exhibicion_padre_id">
                                <option selected hidden value="">Seleccione una exhibición...</option>
                                @foreach ($exhibiciones as $exhibicione)
                                    <option value="{{ $exhibicione->id }}">{{ $exhibicione->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="tipodelcontenido" class="form-label text-blue-dark">Tipo de contenido</label>
                            <select class="form-select" id="tipodelcontenido" name="tipo" required>
                                <option selected hidden value="">Seleccione un tipo...</option>
                                <option value="0">Texto</option>
                                <option value="1">Video</option>
                                <option value="2">Imagenes</option>
                                <option value="3">Galeria Horizontal (Slider)</option>
                                <option value="4">Galeria Vertical</option>
                                <option value="5">Galeria en acordeon</option>
                            </select>
                        </div>
                        
                        <div class="mb-4" id='micontenido' style="display: none">
                            <label for="contenido" class="form-label text-blue-dark">Contenido</label>
                            <textarea name="contenido" id="contenido" class="form-control" rows="6"placeholder="Ingrese el contenido aquí..." style="display: none !important"></textarea>
                        </div>
                        <div class="mb-4" id='mivideo' style="display: none">
                            <label for="contenido" class="form-label text-blue-dark">Videos</label>
                            <input type="file" id="video" name="video" accept="video/*" ><br>
                            <label for="contenido" class="form-label text-blue-dark">descripcion del video (Opcional)</label>
                            <input type="text" class="form-control"  id="descripcionvideo" name="descripcion" placeholder="ingrese descripcion" >
                        </div>
                        <div class="mb-4" id='miimagenes' style="display: none">
                            <label for="contenido" class="form-label text-blue-dark">Imagenes</label>
                            <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple>
                        </div>
                        <div class="mb-4" id='generarCampos' style="display: none">
                            <label for="contenido" class="form-label text-blue-dark">¿Cuántas imágenes deseas cargar?</label>
                            <input type="number" class="form-control"  id="cantidadImagenes" min="1" max="20" onchange="generarCampos()" >
                        </div>
                        <div class="mb-4" id='camposImagenes' style="display: none">
                         
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('contenidos.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar
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
    CKEDITOR.replace('contenido');

</script>
@endsection
