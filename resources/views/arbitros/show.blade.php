@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-whistle"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Información del Árbitro') }}</h2>
                <p class="text-muted mb-0">{{ __('Detalles completos del árbitro') }}: <strong>{{ $arbitro->nombre }}</strong></p>
            </div>

            <!-- Profile Card -->
            <div class="card border-0 shadow-lg profile-card">
                <div class="card-body p-5">
                    <div class="row">
                        <!-- Foto de Perfil -->
                        <div class="col-md-4 text-center mb-4">
                            <div class="profile-image-container">
                                @if($arbitro->foto_carnet)
                                    <img src="{{ asset('storage/' . $arbitro->foto_carnet) }}" 
                                         alt="Foto de {{ $arbitro->nombre }}" 
                                         class="profile-image">
                                @else
                                    <div class="profile-placeholder">
                                        <i class="fas fa-user fa-4x text-muted"></i>
                                    </div>
                                @endif
                                <div class="status-indicator bg-{{ $arbitro->estatus == 'activo' ? 'success' : ($arbitro->estatus == 'sancionado' ? 'warning' : 'secondary') }}"></div>
                            </div>
                            <h4 class="mt-3 mb-1 fw-bold text-dark">{{ $arbitro->nombre }}</h4>
                            <span class="badge bg-{{ $arbitro->estatus == 'activo' ? 'success' : ($arbitro->estatus == 'sancionado' ? 'warning text-dark' : 'secondary') }} {{ $arbitro->estatus == 'sancionado' ? '' : 'text-white' }} px-3 py-2 rounded-pill">
                                <i class="fas fa-{{ $arbitro->estatus == 'activo' ? 'check' : ($arbitro->estatus == 'sancionado' ? 'gavel' : 'pause') }} me-1"></i>
                                {{ ucfirst($arbitro->estatus) }}
                            </span>
                        </div>

                        <!-- Información Personal -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user-circle me-2"></i>
                                        {{ __('Información Personal') }}
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-id-card text-primary me-2"></i>
                                            {{ __('Cédula de Identidad') }}
                                        </div>
                                        <div class="info-value">{{ $arbitro->cedula }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-phone text-primary me-2"></i>
                                            {{ __('Teléfono') }}
                                        </div>
                                        <div class="info-value">{{ $arbitro->telefono ?? 'No especificado' }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            {{ __('Correo Electrónico') }}
                                        </div>
                                        <div class="info-value">{{ $arbitro->email }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-calendar text-primary me-2"></i>
                                            {{ __('Fecha de Registro') }}
                                        </div>
                                        <div class="info-value">{{ $arbitro->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            {{ __('Dirección') }}
                                        </div>
                                        <div class="info-value">{{ $arbitro->direccion ?? 'No especificada' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-folder-open me-2"></i>
                                {{ __('Documentos') }}
                            </h5>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="fas fa-camera text-primary"></i>
                                </div>
                                <h6 class="document-title">{{ __('Foto de Carnet') }}</h6>
                                @if($arbitro->foto_carnet)
                                    <a href="{{ asset('storage/' . $arbitro->foto_carnet) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>
                                        {{ __('Ver') }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('No disponible') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="fas fa-id-badge text-primary"></i>
                                </div>
                                <h6 class="document-title">{{ __('Foto de Cédula') }}</h6>
                                @if($arbitro->foto_cedula)
                                    <a href="{{ asset('storage/' . $arbitro->foto_cedula) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>
                                        {{ __('Ver') }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('No disponible') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="document-card">
                                <div class="document-icon">
                                    <i class="fas fa-file-alt text-primary"></i>
                                </div>
                                <h6 class="document-title">{{ __('Currículum Vitae') }}</h6>
                                @if($arbitro->archivo_cv)
                                    <a href="{{ asset('storage/' . $arbitro->archivo_cv) }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>
                                        {{ __('Descargar') }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('No disponible') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <a href="{{ route('arbitros.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('Volver') }}
                                </a>
                                
                                @if(auth()->user()->rol_id == 'administrador')
                                <div class="btn-group">
                                    <a href="{{ route('arbitros.edit', $arbitro) }}" class="btn btn-warning btn-lg">
                                        <i class="fas fa-edit me-2"></i>
                                        {{ __('Editar') }}
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-lg"
                                            onclick="confirmDelete({{ $arbitro->id }}, '{{ $arbitro->nombre }}')">
                                        <i class="fas fa-trash me-2"></i>
                                        {{ __('Eliminar') }}
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
:root {
    --primary-color: #8F0000;
    --secondary-color: #6B0000;
    --accent-color: #B30000;
    --text-dark: #2d3748;
    --text-light: #718096;
    --white: #ffffff;
    --shadow-light: rgba(0, 0, 0, 0.1);
    --shadow-medium: rgba(0, 0, 0, 0.15);
    --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
}

.page-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: var(--white);
    font-size: 2rem;
    box-shadow: 0 10px 25px rgba(143, 0, 0, 0.3);
    transition: all 0.3s ease;
}

.profile-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.profile-image-container {
    position: relative;
    display: inline-block;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--white);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.profile-image:hover {
    transform: scale(1.05);
}

.profile-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid var(--white);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.status-indicator {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid var(--white);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.info-item {
    background: rgba(248, 249, 250, 0.8);
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
    border-left: 4px solid var(--primary-color);
}

.info-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.info-label {
    font-size: 0.85rem;
    color: var(--text-light);
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.info-value {
    font-size: 1rem;
    color: var(--text-dark);
    font-weight: 500;
}

.document-card {
    background: rgba(248, 249, 250, 0.8);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.document-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.document-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: var(--white);
    font-size: 1.5rem;
    box-shadow: 0 5px 15px rgba(143, 0, 0, 0.3);
}

.document-title {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 1rem;
}

.btn-lg {
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .profile-card {
        margin: 0 0.5rem;
        border-radius: 15px;
    }
    
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .page-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .profile-image,
    .profile-placeholder {
        width: 120px;
        height: 120px;
    }
    
    .btn-lg {
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-group {
        width: 100%;
    }
    
    .btn-group .btn {
        flex: 1;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.5rem 1rem;
    }
    
    .info-item {
        padding: 0.75rem;
    }
    
    .document-card {
        padding: 1rem;
    }
    
    .document-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}
</style>

<script>
// Función para confirmar eliminación
function confirmDelete(id, nombre) {
    if (confirm(`¿Estás seguro de eliminar el árbitro "${nombre}"? Esta acción no se puede deshacer.`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/arbitros/${id}`;
        form.submit();
    }
}
</script>
@endsection
