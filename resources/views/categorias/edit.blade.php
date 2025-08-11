@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Editar Categoria: {{ $categorias->nombre }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('categorias.update', ['categoria' => $categorias->id]) }}" 
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
                                   value="{{ $categorias->nombre }}">
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('categorias.index') }}" class="btn btn-danger">
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
