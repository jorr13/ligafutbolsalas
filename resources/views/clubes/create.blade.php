@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Nueva Categoria</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('clubes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-4">
                            <label for="contenido" class="form-label text-blue-dark">Logo</label>
                            <input type="file" id="logo" name="logo" accept="image/*" multiple>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Rif</label>
                            <input type="text" class="form-control" id="rif" name="rif" required>
                        </div>
                        <div class="mb-4">
                            <label for="exhibicion_padre_id" class="form-label text-blue-dark">Entrenador</label>
                            <select class="form-select" id="entrenador_id" name="entrenador_id">
                                <option selected hidden value="">Seleccione un entrenador...</option>
                                @foreach ($entrenadores as $entrenador)
                                    <option value="{{ $entrenador->id }}">{{ $entrenador->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('clubes.index') }}" class="btn btn-danger">
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
