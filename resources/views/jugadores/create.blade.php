@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Nuevo Jugador</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('jugadores.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label text-blue-dark">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cedula" class="form-label text-blue-dark">Cédula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label text-blue-dark">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-blue-dark">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="direccion" class="form-label text-blue-dark">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="col-md-6">
                                <label for="numero_dorsal" class="form-label text-blue-dark">Número Dorsal</label>
                                <input type="number" class="form-control" id="numero_dorsal" name="numero_dorsal">
                            </div>
                            <div class="col-md-6">
                                <label for="edad" class="form-label text-blue-dark">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label text-blue-dark">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                            <div class="col-md-6">
                                <label for="tipo_sangre" class="form-label text-blue-dark">Tipo de Sangre</label>
                                <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre">
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="status" class="form-label text-blue-dark">Estado</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div> --}}
                            <div class="col-md-6">
                                <label for="club_id" class="form-label text-blue-dark">Club</label>
                                <select class="form-select" id="club_id" name="club_id">
                                    <option value="">Seleccione...</option>
                                    @foreach($clubs as $club)
                                        <option value="{{ $club->id }}">{{ $club->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label text-blue-dark">Categoría</label>
                                <select class="form-select" id="categoria_id" name="categoria_id">
                                    <option value="">Seleccione...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="foto_carnet" class="form-label text-blue-dark">Foto Carnet</label>
                                <input type="file" class="form-control" id="foto_carnet" name="foto_carnet">
                            </div>
                            <div class="col-md-6">
                                <label for="foto_cedula" class="form-label text-blue-dark">Foto Cédula</label>
                                <input type="file" class="form-control" id="foto_cedula" name="foto_cedula">
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="archivo_cv" class="form-label text-blue-dark">Archivo CV</label>
                                <input type="file" class="form-control" id="archivo_cv" name="archivo_cv">
                            </div> --}}
                            <div class="col-md-6">
                                <label for="foto_identificacion" class="form-label text-blue-dark">Foto Identificación</label>
                                <input type="file" class="form-control" id="foto_identificacion" name="foto_identificacion">
                            </div>
                            <div class="col-md-6">
                                <label for="nombre_representante" class="form-label text-blue-dark">Nombre Representante</label>
                                <input type="text" class="form-control" id="nombre_representante" name="nombre_representante">
                            </div>
                            <div class="col-md-6">
                                <label for="cedula_representante" class="form-label text-blue-dark">Cédula Representante</label>
                                <input type="text" class="form-control" id="cedula_representante" name="cedula_representante">
                            </div>
                            <div class="col-md-6">
                                <label for="telefono_representante" class="form-label text-blue-dark">Teléfono Representante</label>
                                <input type="text" class="form-control" id="telefono_representante" name="telefono_representante">
                            </div>
                            <div class="col-12">
                                <label for="observacion" class="form-label text-blue-dark">Observación</label>
                                <textarea class="form-control" id="observacion" name="observacion" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('jugadores.index') }}" class="btn btn-outline-secondary">
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
