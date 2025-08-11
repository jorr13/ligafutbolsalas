@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-blue-dark">Usuarios</h1>
        @if(auth()->user()->rol_id=="administrador")
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            Nuevo Usuario
        </a>
        @endif
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="border-0">Usuario</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Rol</th>
                        <th class="border-0 text-end actions-column">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $user)
                    <tr>
                        <td class="fw-medium text-blue-dark">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->rol_id == 'administrador' ? 'success' : 'secondary' }}">
                                {{ ucfirst($user->rol_id) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                    
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('usuarios.edit', $user->id) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    Editar
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador")
                                <form action="{{ route('usuarios.destroy', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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
