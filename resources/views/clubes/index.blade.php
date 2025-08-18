@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-blue-dark">Clubes</h1>
        @if(auth()->user()->rol_id=="administrador")
        <a href="{{ route('clubes.create') }}" class="btn btn-primary">
            Nuevo Club 
        </a>
        @endif
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="border-0">Nombre</th>
                        <th class="border-0">localidad</th>
                        <th class="border-0">Rif</th>
                        <th class="border-0">Entrenador</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-end actions-column">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clubes as $club)
                    <tr>
                        <td class="fw-medium text-blue-dark">{{ $club->nombre }}</td>
                        <td class="fw-medium text-blue-dark">{{ $club->localidad }}</td>
                        <td class="fw-medium text-blue-dark">{{ $club->rif }}</td>
                        <td class="fw-medium text-blue-dark">{{ $club->entrenador_nombre }}</td>
                        <td>
                            <span class="badge bg-{{ $club->estatus == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($club->estatus) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('clubes.getjugadores', $club->id) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    Ver Jugadores
                                </a>
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('clubes.edit', $club->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    Editar
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('clubes.asignar', $club->id) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    Asignar categoria
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador")
                                <form action="{{ route('clubes.destroy', $club->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar esta club?')">
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
                            <p class="text-muted mb-0">No hay clubes disponibles</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
