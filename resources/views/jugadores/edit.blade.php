@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Editar Jugador: {{ $jugador->nombre }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('jugadores.update', $jugador->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label text-blue-dark">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required value="{{ old('nombre', $jugador->nombre) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="cedula" class="form-label text-blue-dark">Cédula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" required value="{{ old('cedula', $jugador->cedula) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label text-blue-dark">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $jugador->telefono) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-blue-dark">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $jugador->email) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="direccion" class="form-label text-blue-dark">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $jugador->direccion) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="numero_dorsal" class="form-label text-blue-dark">Número Dorsal</label>
                                <input type="number" class="form-control" id="numero_dorsal" name="numero_dorsal" value="{{ old('numero_dorsal', $jugador->numero_dorsal) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="edad" class="form-label text-blue-dark">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad', $jugador->edad) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label text-blue-dark">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $jugador->fecha_nacimiento) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="tipo_sangre" class="form-label text-blue-dark">Tipo de Sangre</label>
                                <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre" value="{{ old('tipo_sangre', $jugador->tipo_sangre) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label text-blue-dark">Estado</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="activo" {{ old('status', $jugador->status) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('status', $jugador->status) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="club_id" class="form-label text-blue-dark">Club</label>
                                <select class="form-select" id="club_id" name="club_id">
                                    <option value="">Seleccione...</option>
                                    @foreach($clubs as $club)
                                        <option value="{{ $club->id }}" {{ old('club_id', $jugador->club_id) == $club->id ? 'selected' : '' }}>{{ $club->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label text-blue-dark">Categoría</label>
                                <select class="form-select" id="categoria_id" name="categoria_id">
                                    <option value="">Seleccione...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $jugador->categoria_id) == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="foto_carnet" class="form-label text-blue-dark">Foto Carnet</label>
                                <input type="file" class="form-control" id="foto_carnet" name="foto_carnet">
                                @if($jugador->foto_carnet)
                                    <small class="d-block mt-1">Actual: <a href="{{ asset('storage/'.$jugador->foto_carnet) }}" target="_blank">Ver archivo</a></small>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="foto_cedula" class="form-label text-blue-dark">Foto Cédula</label>
                                <input type="file" class="form-control" id="foto_cedula" name="foto_cedula">
                                @if($jugador->foto_cedula)
                                    <small class="d-block mt-1">Actual: <a href="{{ asset('storage/'.$jugador->foto_cedula) }}" target="_blank">Ver archivo</a></small>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="archivo_cv" class="form-label text-blue-dark">Archivo CV</label>
                                <input type="file" class="form-control" id="archivo_cv" name="archivo_cv">
                                @if($jugador->archivo_cv)
                                    <small class="d-block mt-1">Actual: <a href="{{ asset('storage/'.$jugador->archivo_cv) }}" target="_blank">Ver archivo</a></small>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="foto_identificacion" class="form-label text-blue-dark">Foto Identificación</label>
                                <input type="file" class="form-control" id="foto_identificacion" name="foto_identificacion">
                                @if($jugador->foto_identificacion)
                                    <small class="d-block mt-1">Actual: <a href="{{ asset('storage/'.$jugador->foto_identificacion) }}" target="_blank">Ver archivo</a></small>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="nombre_representante" class="form-label text-blue-dark">Nombre Representante</label>
                                <input type="text" class="form-control" id="nombre_representante" name="nombre_representante" value="{{ old('nombre_representante', $jugador->nombre_representante) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="cedula_representante" class="form-label text-blue-dark">Cédula Representante</label>
                                <input type="text" class="form-control" id="cedula_representante" name="cedula_representante" value="{{ old('cedula_representante', $jugador->cedula_representante) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="telefono_representante" class="form-label text-blue-dark">Teléfono Representante</label>
                                <input type="text" class="form-control" id="telefono_representante" name="telefono_representante" value="{{ old('telefono_representante', $jugador->telefono_representante) }}">
                            </div>
                            <div class="col-12">
                                <label for="observacion" class="form-label text-blue-dark">Observación</label>
                                <textarea class="form-control" id="observacion" name="observacion" rows="2">{{ old('observacion', $jugador->observacion) }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('jugadores.index') }}" class="btn btn-outline-secondary">
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
@endsection
