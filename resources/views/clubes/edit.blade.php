@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="data:image/png;base64,{{ $clubes->logo }}" 
                             alt="logo" 
                             class="img-fluid"
                             style="max-width: 200px;">
                       {{-- <img src="{{ asset('storage/logo/' . basename($clubes->logo)) }}" alt="Imagen" style="position: relative;height: auto;width: 200px;"> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Editar Club: {{ $clubes->nombre }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('clubes.update', ['clube' => $clubes->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="nombre" class="form-label text-blue-dark">Nombre</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nombre" 
                                   name="nombre" 
                                   required 
                                   value="{{ $clubes->nombre }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="localidad" class="form-label text-blue-dark">localidad</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="localidad" 
                                   name="localidad" 
                                   required 
                                   value="{{ $clubes->localidad }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="rif" class="form-label text-blue-dark">Rif</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="rif" 
                                   name="rif" 
                                   required 
                                   value="{{ $clubes->rif }}">
                        </div>
                        <div class="mb-4">
                            <label for="entrenador_id" class="form-label text-blue-dark">Entrenador</label>
                            <select class="form-select" id="entrenador_id" name="entrenador_id">
                             
                                @foreach ($entrenadores as $entrenador)
                                    <option value="{{ $entrenador->id }}" 
                                        @if($clubes->entrenador_id == $entrenador->id) selected @endif>
                                        {{ $entrenador->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('clubes.index') }}" class="btn btn-danger">
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
