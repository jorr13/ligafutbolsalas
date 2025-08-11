@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-blue-dark">Exhibiciones</h1>
        @if(auth()->user()->rol_id=="administrador")
        <a href="{{ route('exhibiciones.create') }}" class="btn btn-primary">
            Nueva Exhibición
        </a>
        @endif
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="border-0">Título</th>
                        <th class="border-0">URL</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-end actions-column">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($exhibiciones as $exhibicion)
                    <tr>
                        <td class="fw-medium text-blue-dark">{{ $exhibicion->title }}</td>
                        <td class="text-muted">{{ $exhibicion->url }}</td>
                        <td>
                            <span class="badge bg-{{ $exhibicion->estatus == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($exhibicion->estatus) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('exhibiciones.ver', $exhibicion->descrip_url) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    Ver
                                </a>
                                <a href="{{ route('exhibiciones.verQrs', $exhibicion->descrip_url) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    QRs
                                </a>
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('exhibiciones.edit', $exhibicion->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    Editar
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador")
                                <form action="{{ route('exhibiciones.destroy', $exhibicion->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar esta exhibición?')">
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
                            <p class="text-muted mb-0">No hay exhibiciones disponibles</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
