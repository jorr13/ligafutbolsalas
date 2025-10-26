@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Detalle del Jugador') }}</h2>
                <p class="text-muted mb-0">{{ __('Información completa del jugador') }}: <strong>{{ $jugador->nombre }}</strong></p>
            </div>

            <!-- Two Column Layout -->
            <div class="row g-5">
                <!-- Image Preview Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg image-preview-card">
                        <div class="card-body text-center p-4">
                            <div class="club-image-container mb-3">
                                @if($jugador->foto_carnet)
                                    @php
                                        $fotoCarnetUrl = str_starts_with($jugador->foto_carnet, 'jugadores/') 
                                            ? asset('storage/' . $jugador->foto_carnet) 
                                            : asset('images/' . $jugador->foto_carnet);
                                    @endphp
                                    <img src="{{ $fotoCarnetUrl }}" alt="Foto Carnet" class="club-logo">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="fw-bold text-primary mb-2">{{ $jugador->nombre }}</h5>
                            <p class="text-muted mb-1">{{ __('Cédula') }}: {{ $jugador->cedula }}</p>
                            <p class="text-muted mb-1">{{ __('Categoría') }}: {{ $jugador->categoria->nombre ?? 'N/A' }}</p>
                            <p class="text-muted mb-1">{{ __('Nivel') }}: 
                                <span class="badge {{ $jugador->nivel == 'elite' ? 'bg-warning' : 'bg-info' }}">
                                    {{ ucfirst($jugador->nivel ?? 'iniciante') }}
                                </span>
                            </p>
                            <p class="text-muted mb-0">{{ __('Estado') }}: 
                                <span class="badge {{ $jugador->status == 'activo' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($jugador->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg form-card">
                        <div class="card-body p-5">
                            <!-- Información Personal -->
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-primary">
                                    <i class="fas fa-user me-2"></i>
                                    {{ __('Información Personal') }}
                                </h5>
                            </div>
                            
                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-user text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Nombre Completo') }}</h6>
                                        <p class="mb-0">{{ $jugador->nombre }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-id-card text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Cédula de Identidad') }}</h6>
                                        <p class="mb-0">{{ $jugador->cedula }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-phone text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Teléfono') }}</h6>
                                        <p class="mb-0">{{ $jugador->telefono ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-envelope text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Correo Electrónico') }}</h6>
                                        <p class="mb-0">{{ $jugador->email ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Dirección') }}</h6>
                                        <p class="mb-0">{{ $jugador->direccion ?? 'No especificada' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-tshirt text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Número Dorsal') }}</h6>
                                        <p class="mb-0">{{ $jugador->numero_dorsal ?? 'No asignado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-birthday-cake text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Edad') }}</h6>
                                        <p class="mb-0">{{ $jugador->edad ?? 'No especificada' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Fecha de Nacimiento') }}</h6>
                                        <p class="mb-0">{{ $jugador->fecha_nacimiento ? \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-heartbeat text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Tipo de Sangre') }}</h6>
                                        <p class="mb-0">{{ $jugador->tipo_sangre ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-tags text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Categoría') }}</h6>
                                        <p class="mb-0">{{ $jugador->categoria->nombre ?? 'No asignada' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-star text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Nivel') }}</h6>
                                        <p class="mb-0">
                                            <span class="badge {{ $jugador->nivel == 'elite' ? 'bg-warning' : 'bg-info' }}">
                                                {{ ucfirst($jugador->nivel ?? 'iniciante') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del Representante -->
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-primary">
                                    <i class="fas fa-user-tie me-2"></i>
                                    {{ __('Información del Representante') }}
                                </h5>
                            </div>
                            
                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-user text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Nombre del Representante') }}</h6>
                                        <p class="mb-0">{{ $jugador->nombre_representante ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-id-card text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Cédula del Representante') }}</h6>
                                        <p class="mb-0">{{ $jugador->cedula_representante ?? 'No especificada' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-phone text-primary"></i>
                                        <h6 class="fw-bold">{{ __('Teléfono del Representante') }}</h6>
                                        <p class="mb-0">{{ $jugador->telefono_representante ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            @if($jugador->observacion)
                            <div class="section-header mb-4">
                                <h5 class="fw-bold text-primary">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    {{ __('Observaciones') }}
                                </h5>
                            </div>
                            
                            <div class="info-item mb-5">
                                <i class="fas fa-comment text-primary"></i>
                                <h6 class="fw-bold">{{ __('Notas Adicionales') }}</h6>
                                <p class="mb-0">{{ $jugador->observacion }}</p>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <a href="{{ route('jugadores.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('Volver') }}
                                </a>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('jugadores.edit', $jugador->id) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-edit me-2"></i>
                                        {{ __('Editar') }}
                                    </a>
                                    <a href="{{ route('jugadores.carnet.preview', $jugador->id) }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-id-card me-2"></i>
                                        {{ __('Ver Carnet') }}
                                    </a>
                                </div>
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
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --accent-color: #f093fb;
    --text-dark: #2d3748;
    --text-light: #718096;
    --white: #ffffff;
    --shadow-light: rgba(0, 0, 0, 0.1);
    --shadow-medium: rgba(0, 0, 0, 0.15);
    --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, var(--secondary-color) 100%);
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
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
}

.form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.image-preview-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    animation: slideInLeft 0.6s ease-out;
}

.image-preview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.club-image-container {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.club-image-container:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
}

.club-logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.club-logo:hover {
    transform: scale(1.1);
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 3rem;
}

.section-header {
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 1rem;
}

.section-header h5 {
    color: var(--text-dark);
    margin: 0;
}

.info-item {
    padding: 1rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.info-item i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.info-item h6 {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.info-item p {
    color: var(--text-light);
    margin: 0;
}

/* Button Styles */
.btn {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: var(--gradient-primary);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #e2e8f0;
    color: var(--text-dark);
}

.btn-outline-secondary:hover {
    background: #f8fafc;
    border-color: var(--text-light);
    transform: translateY(-2px);
}

/* Animations */
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

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-card, .image-preview-card {
        margin: 1rem;
        border-radius: 16px;
    }
    
    .page-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    
    .btn {
        padding: 0.75rem 1.25rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0 1rem;
    }
    
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .info-item {
        padding: 0.75rem;
    }
    
    .info-item i {
        font-size: 1.25rem;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endsection
