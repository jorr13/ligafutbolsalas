@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-whistle"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Nuevo Árbitro') }}</h2>
                <p class="text-muted mb-0">{{ __('Registra un nuevo árbitro en la Liga de Fútbol Sala') }}</p>
                </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-lg form-card">
                <div class="card-body p-5">
                    <form action="{{ route('arbitros.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
                        @csrf
                        
                        <!-- Nombre del Árbitro -->
                        <div class="form-group mb-4">
                            <label for="nombre" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                {{ __('Nombre Completo') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       required 
                                       placeholder="Ej: Juan Carlos Pérez"
                                       value="{{ old('nombre') }}">
                            </div>
                            @error('nombre')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Cédula -->
                        <div class="form-group mb-4">
                            <label for="cedula" class="form-label fw-semibold">
                                <i class="fas fa-id-card me-2 text-primary"></i>
                                {{ __('Cédula de Identidad') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-hashtag text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('cedula') is-invalid @enderror" 
                                       id="cedula" 
                                       name="cedula" 
                                       required 
                                       maxlength="8"
                                       inputmode="numeric"
                                       pattern="[0-9]*"
                                       autocomplete="off"
                                       placeholder="{{ __('Hasta 8 dígitos') }}"
                                       value="{{ old('cedula') }}">
                            </div>
                            @error('cedula')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group mb-4">
                            <label for="telefono" class="form-label fw-semibold">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                {{ __('Teléfono') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-phone-alt text-muted"></i>
                                </span>
                                <input type="tel" 
                                       class="form-control border-start-0 @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       placeholder="Ej: 0412-1234567"
                                       value="{{ old('telefono') }}">
                            </div>
                            @error('telefono')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Dirección -->
                        <div class="form-group mb-4">
                            <label for="direccion" class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                {{ __('Dirección') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-home text-muted"></i>
                                </span>
                                <textarea class="form-control border-start-0 @error('direccion') is-invalid @enderror" 
                                       id="direccion" 
                                       name="direccion" 
                                          rows="3"
                                          placeholder="Ej: Av. Principal, Sector Los Rosales, Caracas">{{ old('direccion') }}</textarea>
                            </div>
                            @error('direccion')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                {{ __('Correo Electrónico') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-at text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       required 
                                       placeholder="Ej: juan.perez@email.com"
                                       value="{{ old('email') }}">
                        </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                        </div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group mb-4">
                            <label for="pass" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>
                                {{ __('Contraseña') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0 @error('pass') is-invalid @enderror" 
                                       id="pass" 
                                       name="pass" 
                                       required 
                                       placeholder="Mínimo 6 caracteres">
                        </div>
                            @error('pass')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                        </div>
                            @enderror
                        </div>

                        <!-- Foto Carnet -->
                        <div class="form-group mb-4">
                            <label for="foto_carnet" class="form-label fw-semibold">
                                <i class="fas fa-camera me-2 text-primary"></i>
                                {{ __('Foto para Carnet') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-image text-muted"></i>
                                </span>
                                    <input type="file" 
                                       class="form-control border-start-0 @error('foto_carnet') is-invalid @enderror" 
                                           id="foto_carnet" 
                                           name="foto_carnet" 
                                       accept="image/*">
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                            </small>
                            @error('foto_carnet')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Foto Cédula -->
                        <div class="form-group mb-4">
                            <label for="foto_cedula" class="form-label fw-semibold">
                                <i class="fas fa-id-badge me-2 text-primary"></i>
                                {{ __('Foto de Cédula') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-file-image text-muted"></i>
                                </span>
                                    <input type="file" 
                                       class="form-control border-start-0 @error('foto_cedula') is-invalid @enderror" 
                                           id="foto_cedula" 
                                           name="foto_cedula" 
                                       accept="image/*">
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                            </small>
                            @error('foto_cedula')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Archivo CV -->
                        <div class="form-group mb-4">
                            <label for="archivo_cv" class="form-label fw-semibold">
                                <i class="fas fa-file-alt me-2 text-primary"></i>
                                {{ __('Currículum Vitae') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-file-pdf text-muted"></i>
                                </span>
                                    <input type="file" 
                                       class="form-control border-start-0 @error('archivo_cv') is-invalid @enderror" 
                                           id="archivo_cv" 
                                           name="archivo_cv" 
                                       accept=".pdf,.doc,.docx">
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 5MB
                            </small>
                            @error('archivo_cv')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <a href="{{ route('arbitros.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold submit-btn">
                                <i class="fas fa-save me-2"></i>
                                {{ __('Guardar Árbitro') }}
                            </button>
                        </div>
                    </form>
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
    box-shadow: 0 10px 25px rgba(143, 0, 0, 0.3);
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
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.form-group {
    position: relative;
}

.form-label {
    color: var(--text-dark);
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.input-group {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.input-group:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.input-group-text {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    color: var(--text-light);
    font-size: 0.9rem;
    padding: 0.75rem 1rem;
    min-width: 50px;
    justify-content: center;
}

.form-control {
    border: none;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    background: var(--white);
    color: var(--text-dark);
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: none;
    background: #f8f9fa;
}

.form-control::placeholder {
    color: #adb5bd;
    font-style: italic;
}

.submit-btn {
    background: var(--gradient-primary);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(143, 0, 0, 0.4);
}

.submit-btn:active {
    transform: translateY(0);
}

.btn-outline-secondary {
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
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
    
    .form-card {
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
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .input-group-text {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }
    
    .form-control {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cedula = document.getElementById('cedula');
    if (cedula) {
        cedula.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 8);
        });
    }
});
</script>
@endsection