@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Nuevo Entrenador</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('entrenadores.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Cedula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">contrasena</label>
                            <input type="password" class="form-control" id="pass" name="pass" required>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('entrenadores.index') }}" class="btn btn-outline-secondary">
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
</script>
@endsection
