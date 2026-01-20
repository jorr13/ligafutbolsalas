@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i> 
                        Historial del Club: {{ $club->nombre }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('clubes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver a Clubes
                        </a>
                        <a href="{{ route('clubes.historial.exportar', $club->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Exportar CSV
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Información del Club -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text"> <i class="fas fa-futbol"></i> Club</span>
                                    <span class="info-box-number">{{ $club->nombre }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">

                                <div class="info-box-content">
                                    <span class="info-box-text"><i class="fas fa-map-marker-alt"></i> Localidad</span>
                                    <span class="info-box-number">{{ $club->localidad ?? 'No especificada' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <form method="GET" action="{{ route('clubes.historial', $club->id) }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Acción:</label>
                                                    <select name="accion" class="form-control">
                                                        <option value="">Todas las acciones</option>
                                                        <option value="creacion" {{ request('accion') == 'creacion' ? 'selected' : '' }}>Club creado</option>
                                                        <option value="modificacion" {{ request('accion') == 'modificacion' ? 'selected' : '' }}>Club modificado</option>
                                                        <option value="jugador_ingreso" {{ request('accion') == 'jugador_ingreso' ? 'selected' : '' }}>Jugador agregado</option>
                                                        <option value="jugador_salida" {{ request('accion') == 'jugador_salida' ? 'selected' : '' }}>Jugador removido</option>
                                                        <option value="entrenador_asignado" {{ request('accion') == 'entrenador_asignado' ? 'selected' : '' }}>Entrenador asignado</option>
                                                        <option value="entrenador_removido" {{ request('accion') == 'entrenador_removido' ? 'selected' : '' }}>Entrenador removido</option>
                                                        <option value="categoria_asignada" {{ request('accion') == 'categoria_asignada' ? 'selected' : '' }}>Categoría asignada</option>
                                                        <option value="categoria_removida" {{ request('accion') == 'categoria_removida' ? 'selected' : '' }}>Categoría removida</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha desde:</label>
                                                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha hasta:</label>
                                                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-search"></i> Filtrar
                                                        </button>
                                                        <a href="{{ route('clubes.historial', $club->id) }}" class="btn btn-secondary">
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

                    <!-- Historial -->
                    <div class="timeline">
                        @forelse($historial as $item)
                        <div class="time-label">
                            <span class="bg-{{ $item->accion == 'creacion' ? 'success' : ($item->accion == 'modificacion' ? 'warning' : 'info') }}">
                                {{ $item->fecha_accion->format('d M Y') }}
                            </span>
                        </div>
                        
                        <div>
                            <i class="{{ $item->accion_icono }}"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="fas fa-clock"></i> 
                                    {{ $item->fecha_accion->format('H:i') }}
                                </span>
                                <h3 class="timeline-header">
                                    <strong>{{ $item->accion_texto }}</strong>
                                    @if($item->usuario)
                                        por <strong>{{ $item->usuario->name }}</strong>
                                    @endif
                                </h3>
                                <div class="timeline-body">
                                    <p>{{ $item->descripcion }}</p>
                                    
                                    @if($item->jugador)
                                        <p><strong>Jugador:</strong> {{ $item->jugador->nombre }}</p>
                                    @endif
                                    
                                    @if($item->entrenador)
                                        <p><strong>Entrenador:</strong> {{ $item->entrenador->nombre }}</p>
                                    @endif
                                    
                                    @if($item->categoria)
                                        <p><strong>Categoría:</strong> {{ $item->categoria->nombre }}</p>
                                    @endif
                                    
                                    @if($item->clubRelacionado)
                                        <p><strong>Club relacionado:</strong> {{ $item->clubRelacionado->nombre }}</p>
                                    @endif
                                    
                                    @if($item->campo_modificado)
                                        <div class="alert alert-info">
                                            <strong>Campo modificado:</strong> {{ $item->campo_modificado }}<br>
                                            <strong>Valor anterior:</strong> {{ $item->valor_anterior }}<br>
                                            <strong>Valor nuevo:</strong> {{ $item->valor_nuevo }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="time-label" style="text-align: center;">
                            <span><i class="fas fa-clock bg-gray"></i>Sin registros</span>
                        </div>
                       
                        @endforelse
             
                    </div>

                    <!-- Paginación -->
                    @if($historial->hasPages())
                    @php
                        app()->setLocale('es');
                    @endphp
                    <div class="pagination-container mt-4">
                        <div class="pagination-wrapper">
                            <div class="pagination-info">
                                Mostrando {{ $historial->firstItem() }} a {{ $historial->lastItem() }} de {{ $historial->total() }} registros
                            </div>
                            <div class="pagination-box">
                                {{ $historial->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
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
/* Estilos minimalistas para el paginador */
.pagination-container {
    background: #ffffff;
    border-top: 1px solid #e9ecef;
    padding: 1.5rem 1rem;
    margin-top: 0;
}

.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 400;
}

.pagination-box {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

.pagination-box > div:first-child {
    display: none !important;
}

.pagination {
    margin: 0;
    display: flex;
    list-style: none;
    padding: 0;
    gap: 0.5rem;
    align-items: center;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    color: #333333;
    background: transparent;
    border: none;
    padding: 0.5rem 0.75rem;
    margin: 0;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    line-height: 1.5;
    font-weight: 400;
}

.pagination .page-link:hover:not(.disabled):not(.active-link) {
    color: #007bff;
    text-decoration: underline;
}

.pagination .page-item:last-child .page-link:not(.disabled) {
    background-color: #007bff;
    color: #ffffff !important;
    font-weight: 400;
    border-radius: 4px;
    padding: 0.5rem 1rem;
    text-decoration: none;
}

.pagination .page-item:last-child .page-link:not(.disabled):hover {
    background-color: #0056b3;
    text-decoration: none;
    color: #ffffff !important;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #ffffff;
    font-weight: 500;
    border-radius: 4px;
    padding: 0.5rem 0.75rem;
}

.pagination .page-item.active .page-link:hover {
    text-decoration: none;
}

.pagination .page-item.disabled .page-link {
    color: #999999;
    cursor: not-allowed;
    pointer-events: none;
    opacity: 0.6;
}

.pagination .page-item.disabled .page-link:hover {
    text-decoration: none;
}

.pagination .page-item:not(.active):not(.disabled):not(:first-child):not(:last-child) {
    display: none;
}

.pagination-box > div:not(.pagination):not(nav) {
    display: none !important;
}

.pagination-box > p,
.pagination-box > small {
    display: none !important;
}

@media (max-width: 768px) {
    .pagination-container {
        padding: 1.25rem 0.75rem;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }
    
    .pagination-info {
        order: 2;
        text-align: center;
    }
    
    .pagination-box {
        order: 1;
        width: 100%;
        justify-content: center;
    }
    
    .pagination {
        width: 100%;
        justify-content: center;
    }
    
    .pagination .page-link {
        padding: 0.6rem 0.8rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .pagination-container {
        padding: 1rem 0.5rem;
    }
    
    .pagination-info {
        font-size: 0.85rem;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.7rem;
        font-size: 0.85rem;
    }
}

.timeline {
    position: relative;
    padding: 0 0 20px 0;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 31px;
    height: 100%;
    width: 3px;
    background: #dee2e6;
}

.timeline > div {
    position: relative;
    margin-bottom: 15px;
}

.timeline > div:before,
.timeline > div:after {
    content: '';
    display: table;
}

.timeline > div:after {
    clear: both;
}

.timeline > div > .timeline-item {
    margin-left: 60px;
    margin-right: 15px;
    background: #fff;
    border-radius: 0.25rem;
    padding: 0 0 0 0;
    position: relative;
    border: 1px solid #dee2e6;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.timeline > div > .timeline-item > .time {
    color: #999;
    float: right;
    padding: 10px;
    font-size: 12px;
}

.timeline > div > .timeline-item > .timeline-header {
    margin: 0;
    color: #495057;
    border-bottom: 1px solid #dee2e6;
    padding: 10px 15px;
    font-size: 16px;
    line-height: 1.1;
}

.timeline > div > .timeline-item > .timeline-body,
.timeline > div > .timeline-item > .timeline-footer {
    padding: 10px 15px;
}

.timeline > div > i {
    width: 30px;
    height: 30px;
    font-size: 15px;
    line-height: 30px;
    position: absolute;
    color: #666;
    background: #fff;
    border-radius: 50%;
    text-align: center;
    left: 18px;
    top: 0;
    border: 3px solid #dee2e6;
}

.timeline .time-label > span {
    font-weight: 600;
    padding: 5px 10px;
    background: #6c757d;
    color: #fff;
    border-radius: 4px;
    font-size: 12px;
}

.timeline .time-label {
    margin: 0 0 30px 0;
    position: relative;
}

.timeline .time-label:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: #dee2e6;
    top: 50%;
    z-index: 1;
}

.timeline .time-label > span {
    position: relative;
    z-index: 2;
    background: #6c757d;
    display: inline-block;
    padding: 5px 10px;
    border-radius: 4px;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
}
</style>
@endpush
