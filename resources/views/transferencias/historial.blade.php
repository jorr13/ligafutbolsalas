@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header del jugador -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-gradient-primary text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-history me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0">Historial de {{ $jugador->nombre }}</h4>
                            <small>Registro completo de transferencias y ediciones</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.jugadores.transferir', $jugador->id) }}" 
                           class="btn btn-light btn-sm">
                            <i class="fas fa-exchange-alt me-2"></i>Transferir
                        </a>
                        <a href="{{ route('jugadores.index') }}" 
                           class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            @if($jugador->foto_carnet && Storage::disk('images')->exists($jugador->foto_carnet))
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 overflow-hidden player-photo" 
                                     style="width: 80px; height: 80px; border: 3px solid #667eea;">
                                    <img src="{{ Storage::disk('images')->url($jugador->foto_carnet) }}" 
                                         alt="{{ $jugador->nombre }}" 
                                         class="w-100 h-100 object-fit-cover">
                                </div>
                            @else
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            @endif
                            <h5 class="mb-1">{{ $jugador->nombre }}</h5>
                            <p class="text-muted mb-0">{{ $jugador->cedula }}</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-info-circle me-2"></i>Información Actual
                                </h6>
                                <p class="mb-1"><strong>Club:</strong> {{ $jugador->club->nombre ?? 'Sin club' }}</p>
                                <p class="mb-1"><strong>Categoría:</strong> {{ $jugador->categoria->nombre ?? 'Sin categoría' }}</p>
                                <p class="mb-1"><strong>Estado:</strong> 
                                    <span class="badge bg-{{ $jugador->status == 'activo' ? 'success' : ($jugador->status == 'pendiente' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($jugador->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-2">
                                    <i class="fas fa-chart-line me-2"></i>Estadísticas
                                </h6>
                                <p class="mb-1"><strong>Total Transferencias:</strong> {{ $historial->where('tipo_movimiento', 'transferencia')->count() }}</p>
                                <p class="mb-1"><strong>Total Ediciones:</strong> {{ $historial->where('tipo_movimiento', 'edicion')->count() }}</p>
                                <p class="mb-0"><strong>Última Actividad:</strong> 
                                    {{ $historial->first() ? $historial->first()->fecha_movimiento->format('d/m/Y H:i') : 'Sin registros' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de movimientos -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-light">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-list me-2"></i>Registro de Actividades
                </h5>
            </div>
            
            <div class="card-body p-0">
                @if($historial->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Fecha</th>
                                    <th class="border-0">Tipo</th>
                                    <th class="border-0">Descripción</th>
                                    <th class="border-0">Clubes</th>
                                    <th class="border-0">Administrador</th>
                                    <th class="border-0">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historial as $movimiento)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">{{ $movimiento->fecha_movimiento->format('d/m/Y') }}</span>
                                                <small class="text-muted">{{ $movimiento->fecha_movimiento->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            @if($movimiento->tipo_movimiento == 'transferencia')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-exchange-alt me-1"></i>Transferencia
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    <i class="fas fa-edit me-1"></i>Edición
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-dark">{{ $movimiento->descripcion }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if($movimiento->tipo_movimiento == 'transferencia')
                                                <div class="d-flex flex-column">
                                                    @if($movimiento->clubAnterior)
                                                        <small class="text-muted">
                                                            <i class="fas fa-arrow-left me-1"></i>{{ $movimiento->clubAnterior->nombre }}
                                                        </small>
                                                    @endif
                                                    @if($movimiento->clubNuevo)
                                                        <small class="text-primary fw-bold">
                                                            <i class="fas fa-arrow-right me-1"></i>{{ $movimiento->clubNuevo->nombre }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold">{{ $movimiento->usuario->name }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ ucfirst($movimiento->usuario->rol_id) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            @if($movimiento->tipo_movimiento == 'edicion' && $movimiento->campo_modificado)
                                                <button class="btn btn-outline-info btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#detallesModal{{ $movimiento->id }}">
                                                    <i class="fas fa-eye me-1"></i>Ver Cambios
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-history fa-2x text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-2">Sin historial registrado</h5>
                        <p class="text-muted mb-4">Este jugador aún no tiene transferencias o ediciones registradas.</p>
                        <a href="{{ route('admin.jugadores.transferir', $jugador->id) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-exchange-alt me-2"></i>Realizar Primera Transferencia
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modales para mostrar detalles de ediciones -->
@foreach($historial->where('tipo_movimiento', 'edicion') as $movimiento)
    <div class="modal fade" id="detallesModal{{ $movimiento->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Detalles de Edición
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Información del Cambio</h6>
                            <p><strong>Campo Modificado:</strong> {{ ucfirst(str_replace('_', ' ', $movimiento->campo_modificado)) }}</p>
                            <p><strong>Fecha:</strong> {{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</p>
                            <p><strong>Administrador:</strong> {{ $movimiento->usuario->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Valores</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-2"><strong>Valor Anterior:</strong></p>
                                <p class="text-muted mb-3">{{ $movimiento->valor_anterior ?? 'Sin valor' }}</p>
                                
                                <p class="mb-2"><strong>Valor Nuevo:</strong></p>
                                <p class="text-success fw-bold">{{ $movimiento->valor_nuevo ?? 'Sin valor' }}</p>
                            </div>
                        </div>
                    </div>
                    @if($movimiento->descripcion)
                        <div class="mt-3">
                            <h6 class="text-primary mb-2">Descripción</h6>
                            <p class="text-muted">{{ $movimiento->descripcion }}</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #f8f9fa;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.object-fit-cover {
    object-fit: cover;
}

.player-photo {
    transition: all 0.3s ease;
}

.player-photo:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}
</style>
@endsection
