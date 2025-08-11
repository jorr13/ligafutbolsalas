@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-blue-dark">Jugadores</h1>
        <a href="{{ route('jugadores.create') }}" class="btn btn-primary">
            Nuevo Jugador
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="border-0">Nombre</th>
                        <th class="border-0">Cédula</th>
                        <th class="border-0">Teléfono</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Club</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-end actions-column">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jugadores as $jugador)
                    <tr>
                        <td class="fw-medium text-blue-dark">{{ $jugador->nombre }}</td>
                        <td>{{ $jugador->cedula }}</td>
                        <td>{{ $jugador->telefono }}</td>
                        <td>{{ $jugador->email }}</td>
                        <td>{{ $jugador->club_nombre ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $jugador->status == 'activo' ? 'success' : 'warning' }}">
                                {{ ucfirst($jugador->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                {{-- @if(auth()->user()->rol_id=="administrador") --}}
                                    @if($jugador->status!="activo")
                                        <a href="{{ route('jugadores.edit', $jugador->id) }}" 
                                        class="btn btn-outline-warning btn-sm">
                                            Editar
                                        </a>
                                    @endif
                                {{-- @endif --}}
                                @if(auth()->user()->rol_id=="administrador")
                                {{-- <a href="{{ route('jugadores.edit', $jugador->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    Editar
                                </a> --}}
                                <form action="{{ route('jugadores.aceptar', $jugador->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-outline-info btn-sm"
                                            onclick="return confirm('¿Estás seguro de aceptar este jugador?')">
                                        Aceptar
                                    </button>
                                </form>
                                <form action="{{ route('jugadores.destroy', $jugador->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de rechazar este jugador?')">
                                        Rechazar
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay jugadores disponibles</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
