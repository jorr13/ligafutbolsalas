@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-blue-dark">Entrenadores</h1>
        @if(auth()->user()->rol_id=="administrador")
        <a href="{{ route('entrenadores.create') }}" class="btn btn-primary">
            Nuevo Entrenador 
        </a>
        @endif
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="border-0">Nombre</th>
                        <th class="border-0">cedula</th>
                        <th class="border-0">telefono</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">direccion</th>
                        <th class="border-0">Club</th> 
                        <th class="border-0">Estatus</th> 
                        {{-- <th class="border-0">Foto carnet</th>
                        <th class="border-0">Foto cedula</th>
                        <th class="border-0">Archivo Cv</th> --}}
                        <th class="border-0 text-end actions-column">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($entrenadores as $entrenador)
                    <tr>
                        <td class="fw-medium text-blue-dark">{{ $entrenador->nombre }}</td>
                        <td class="fw-medium text-blue-dark">{{ $entrenador->cedula }}</td>
                        <td class="fw-medium text-blue-dark">{{ $entrenador->telefono }}</td>
                        <td class="fw-medium text-blue-dark">{{ $entrenador->email }}</td>
                        <td class="fw-medium text-blue-dark">{{ $entrenador->direccion }}</td>
                        <td class="fw-medium text-blue-dark">{{ $entrenador->nombre_club }}</td>
                        <td>
                            <span class="badge bg-{{ $entrenador->estatus == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($entrenador->estatus) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('entrenadores.edit', $entrenador->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    Editar
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador")
                                <form action="{{ route('entrenadores.destroy', $entrenador->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar esta categoria?')">
                                        Eliminar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="fas fa-museum fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay categorias disponibles</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
