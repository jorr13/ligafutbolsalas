@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i> 
                        Historial General de Clubes
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('clubes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver a Clubes
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Filtros</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('clubes.historial.general') }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Club:</label>
                                                    <select name="club_id" class="form-control">
                                                        <option value="">Todos los clubes</option>
                                                        @foreach($clubes as $club)
                                                            <option value="{{ $club->id }}" {{ request('club_id') == $club->id ? 'selected' : '' }}>
                                                                {{ $club->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Acción:</label>
                                                    <select name="accion" class="form-control">
                                                        <option value="">Todas las acciones</option>
                                                        @foreach($acciones as $key => $value)
                                                            <option value="{{ $key }}" {{ request('accion') == $key ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Usuario:</label>
                                                    <select name="usuario_id" class="form-control">
                                                        <option value="">Todos los usuarios</option>
                                                        @foreach($usuarios as $usuario)
                                                            <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                                                {{ $usuario->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Fecha desde:</label>
                                                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Fecha hasta:</label>
                                                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-search"></i> Filtrar
                                                        </button>
                                                        <a href="{{ route('clubes.historial.general') }}" class="btn btn-secondary">
                                                            <i class="fas fa-times"></i> Limpiar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de historial -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Club</th>
                                    <th>Acción</th>
                                    <th>Descripción</th>
                                    <th>Usuario</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historial as $item)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $item->fecha_accion->format('d/m/Y') }}<br>
                                            {{ $item->fecha_accion->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ $item->club->nombre }}</strong>
                                        @if($item->club->localidad)
                                            <br><small class="text-muted">{{ $item->club->localidad }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $item->accion == 'creacion' ? 'success' : ($item->accion == 'modificacion' ? 'warning' : 'info') }}">
                                            <i class="{{ $item->accion_icono }}"></i>
                                            {{ $item->accion_texto }}
                                        </span>
                                    </td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td>
                                        @if($item->usuario)
                                            <span class="badge badge-secondary">{{ $item->usuario->name }}</span>
                                        @else
                                            <span class="badge badge-light">Sistema</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->jugador)
                                            <small class="text-info">
                                                <i class="fas fa-user"></i> {{ $item->jugador->nombre }}
                                            </small><br>
                                        @endif
                                        @if($item->entrenador)
                                            <small class="text-primary">
                                                <i class="fas fa-user-tie"></i> {{ $item->entrenador->nombre }}
                                            </small><br>
                                        @endif
                                        @if($item->categoria)
                                            <small class="text-success">
                                                <i class="fas fa-tag"></i> {{ $item->categoria->nombre }}
                                            </small><br>
                                        @endif
                                        @if($item->clubRelacionado)
                                            <small class="text-warning">
                                                <i class="fas fa-exchange-alt"></i> {{ $item->clubRelacionado->nombre }}
                                            </small><br>
                                        @endif
                                        @if($item->campo_modificado)
                                            <small class="text-muted">
                                                <i class="fas fa-edit"></i> {{ $item->campo_modificado }}
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        No se encontraron registros con los filtros aplicados.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($historial->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $historial->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.badge {
    font-size: 0.75em;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

.text-muted {
    font-size: 0.85em;
}
</style>
@endpush
