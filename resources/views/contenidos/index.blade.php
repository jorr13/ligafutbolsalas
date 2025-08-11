@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-blue-dark">Contenidos</h1>
        @if(auth()->user()->rol_id=="administrador" or auth()->user()->rol_id=="editor")
        <a href="{{ route('contenidos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuevo Contenido
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
                        <th class="border-0">Tipo de contenido</th>
                        <th class="border-0">Tipo</th>
                        <th class="border-0 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contenidos as $contenido)
                    <tr>
                        <td class="fw-medium text-blue-dark">{{ $contenido->title }}</td>
                        <td class="text-muted">{{ $contenido->url }}</td>
                        <td>
                            <span class="badge bg-{{ $contenido->tipo_contenido == 0 ? 'primary' : 'info' }}">
                                {{ $contenido->tipo_contenido == 0 ? 'Texto' : 'Otro' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $contenido->tipo == 0 ? 'success' : 'warning' }}">
                                {{ $contenido->tipo == 0 ? 'General' : 'Dependiente' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('contenidos.verqr', $contenido->id) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Ver Contenido
                                </a>
                                <a href="data:image/png;base64,{{ $contenido->qr }}" 
                                   class="btn btn-outline-info btn-sm"
                                   target="_blank">
                                    <i class="fas fa-qrcode me-1"></i>Ver QR
                                </a>
                                @if(auth()->user()->rol_id=="administrador" or auth()->user()->rol_id=="editor")
                                <a href="{{ route('contenidos.edit', $contenido->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador" or auth()->user()->rol_id=="editor")
                                <form action="{{ route('contenidos.destroy', $contenido->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este contenido?')">
                                        <i class="fas fa-trash me-1"></i>Eliminar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay contenidos disponibles</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
