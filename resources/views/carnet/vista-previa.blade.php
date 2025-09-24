@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-id-card"></i> 
                        Vista Previa del Carnet - {{ $jugador->nombre }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Información del jugador -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><strong>Información del Jugador:</strong></h6>
                            <p><strong>Nombre:</strong> {{ $jugador->nombre }}</p>
                            <p><strong>Cédula:</strong> {{ $jugador->cedula }}</p>
                            <p><strong>Club:</strong> {{ $jugador->club->nombre ?? 'N/A' }}</p>
                            <p><strong>Categoría:</strong> {{ $jugador->categoria->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Estado:</strong></h6>
                            <span class="badge badge-{{ $jugador->status == 'Activo' ? 'success' : 'warning' }}">
                                {{ ucfirst($jugador->status ?? 'activo') }}
                            </span>
                            
                            @if($jugador->observacion)
                            <h6 class="mt-3"><strong>Observaciones:</strong></h6>
                            <p class="text-muted">{{ $jugador->observacion }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Vista previa del carnet -->
                    <div class="text-center mb-4">
                        <h5>Vista Previa del Carnet</h5>
                        <div class="border p-3 d-inline-block" style="background: #f8f9fa;">
                            @include('carnet.template')
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-center">
                        <a href="{{ route('jugadores.carnet', $jugador->id) }}" 
                           class="btn btn-primary btn-lg mr-3">
                            <i class="fas fa-download"></i> 
                            Descargar Carnet PDF
                        </a>
                        
                        <a href="{{ url()->previous() }}" 
                           class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> 
                            Volver
                        </a>
                    </div>

                    <!-- Información adicional -->
                    <div class="alert alert-info mt-4">
                        <h6><i class="fas fa-info-circle"></i> Información Importante:</h6>
                        <ul class="mb-0">
                            <li>El carnet se generará en formato PDF optimizado para impresión</li>
                            <li>Tamaño recomendado: A4 (210 x 297 mm)</li>
                            <li>El archivo se descargará automáticamente al hacer clic en "Descargar Carnet PDF"</li>
                            @if(!$jugador->foto_carnet)
                            <li class="text-warning"><strong>Nota:</strong> Este jugador no tiene foto asignada</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-lg {
        padding: 12px 30px;
        font-size: 16px;
    }
    
    .alert-info {
        border-left: 4px solid #17a2b8;
    }
    
    .badge {
        font-size: 14px;
        padding: 8px 12px;
    }
</style>
@endsection

