@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="card-header bg-gradient-white">
                            <h5 class="mb-0 text-blue-dark">Asignadas:</h5>
                        </div>
                        <ul>
                            @if($categoriasAsign)
                            @foreach ($categoriasAsign as $asignadas)
                                <li>
                                    {{ $asignadas->nombre_categoria }}
                                <form action="{{ route('clubes.deleteasignar') }}" 
                                      method="POST" 
                                      class="d-inline"
                                      method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $asignadas->id }}">
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar esta club?')">
                                        Eliminar
                                    </button>
                                </form>
                                </li>
                                    
                            @endforeach
                            @endif
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Asignar {{ $clubes->nombre }} a una Categoria</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('clubes.creasignar', ['id' => $clubes->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="categorias_id" class="form-label text-blue-dark">Categorias</label>
                            <select class="form-select" id="categorias_id" name="categorias_id">
                                <option selected hidden value="">
                                    Seleccione una categoria...
                                </option>
                                @foreach ($categoria as $catego)
                                    <option value="{{ $catego->id }}" >
                                        {{ $catego->nombre }}
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
