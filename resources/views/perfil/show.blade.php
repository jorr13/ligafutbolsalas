@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Mi Perfil') }}</h2>
                <p class="text-muted mb-0">{{ __('Información personal y datos de tu cuenta') }}</p>
            </div>

            <!-- Profile Card -->
            <div class="card border-0 shadow-lg profile-card">
                <div class="card-body p-5">
                    <div class="row">
                        <!-- Información Básica -->
                        <div class="col-md-6 mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-user me-2"></i>
                                {{ __('Información Básica') }}
                            </h5>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    {{ __('Nombre Completo') }}
                                </div>
                                <div class="info-value">{{ $user->name }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    {{ __('Correo Electrónico') }}
                                </div>
                                <div class="info-value">{{ $user->email }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-shield-alt text-primary me-2"></i>
                                    {{ __('Rol') }}
                                </div>
                                <div class="info-value">
                                    <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                        <i class="fas fa-{{ $user->rol_id == 'administrador' ? 'crown' : ($user->rol_id == 'entrenador' ? 'user-tie' : 'whistle') }} me-1"></i>
                                        {{ ucfirst($user->rol_id) }}
                                    </span>
                                </div>
                            </div>

         
                        </div>

                        <!-- Información Adicional (si aplica) -->
                        <div class="col-md-6 mb-4">
                            @if($datosAdicionales)
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ __('Información Adicional') }}
                                </h5>
                                
                                @if($user->rol_id == 'entrenador' || $user->rol_id == 'arbitro')
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-id-card text-primary me-2"></i>
                                            {{ __('Cédula de Identidad') }}
                                        </div>
                                        <div class="info-value">{{ $datosAdicionales->cedula ?? 'No especificada' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-phone text-primary me-2"></i>
                                            {{ __('Teléfono') }}
                                        </div>
                                        <div class="info-value">{{ $datosAdicionales->telefono ?? 'No especificado' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            {{ __('Dirección') }}
                                        </div>
                                        <div class="info-value">{{ $datosAdicionales->direccion ?? 'No especificada' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-circle text-primary me-2"></i>
                                            {{ __('Estado') }}
                                        </div>
                                        <div class="info-value">
                                            <span class="badge bg-{{ $datosAdicionales->estatus == 'activo' ? 'success' : 'secondary' }} text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-{{ $datosAdicionales->estatus == 'activo' ? 'check' : 'pause' }} me-1"></i>
                                                {{ ucfirst($datosAdicionales->estatus) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">{{ __('No hay información adicional') }}</h6>
                                    <p class="text-muted small">{{ __('Solo tienes información básica de usuario') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Documentos (solo para entrenadores y árbitros) -->
                    @if($datosAdicionales && ($user->rol_id == 'entrenador' || $user->rol_id == 'arbitro'))
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
                                @if($datosAdicionales->foto_carnet)
                                    <a href="{{ asset('storage/' . $datosAdicionales->foto_carnet) }}" 
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
                                @if($datosAdicionales->foto_cedula)
                                    <a href="{{ asset('storage/' . $datosAdicionales->foto_cedula) }}" 
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
                                @if($datosAdicionales->archivo_cv)
                                    <a href="{{ asset('storage/' . $datosAdicionales->archivo_cv) }}" 
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
                    @endif

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('Volver al Inicio') }}
                                </a>
                                
                                <a href="{{ route('perfil.edit') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-edit me-2"></i>
                                    {{ __('Editar Perfil') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.info-item {
    background: rgba(248, 249, 250, 0.8);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
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
    
    .btn-lg {
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
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
@endsection
