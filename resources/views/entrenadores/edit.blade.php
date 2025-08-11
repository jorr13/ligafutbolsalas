@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Editar Entrenador: {{ $entrenadores->nombre }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('entrenadores.update', ['entrenadore' => $entrenadores->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $entrenadores->nombre }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Cedula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" value="{{ $entrenadores->cedula }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $entrenadores->telefono }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $entrenadores->direccion }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ $entrenadores->email }}" required>
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
@endsection
