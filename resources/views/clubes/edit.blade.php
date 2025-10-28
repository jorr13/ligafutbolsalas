@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-edit"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Editar Club') }}</h2>
                <p class="text-muted mb-0">{{ __('Modifica la información del club') }}: <strong>{{ $clubes->nombre }}</strong></p>
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Club Image Preview -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg image-preview-card">
                        <div class="card-body p-4 text-center">
                            <div class="club-image-container mb-3">
                                @if($clubes->logo)
                                @php
                                $logoUrl = str_starts_with($clubes->logo, 'logos/') 
                                    ? asset('storage/' . $clubes->logo) 
                                    : asset('images/' . $clubes->logo);
                            @endphp
                                       <img src="{{ $logoUrl }}" 
                                         alt="Logo de {{ $clubes->logo }}" 
                                         class="club-logo img-fluid rounded"
                                         id="currentLogo">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image text-muted fs-1"></i>
                                        <p class="text-muted mt-2">{{ __('Sin logo') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="club-info">
                                <h5 class="fw-bold text-primary mb-2">{{ $clubes->nombre }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $clubes->localidad }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-hashtag me-1"></i>
                                    {{ $clubes->rif }}
                                </p>
                    </div>
                </div>
            </div>
        </div>

                <!-- Edit Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg form-card">
                        <div class="card-body p-5">
                    <form action="{{ route('clubes.update', ['clube' => $clubes->id]) }}" 
                          method="POST" 
                                  enctype="multipart/form-data" 
                                  class="edit-form">
                        @csrf
                        @method('PATCH')
                        
                                <!-- Nombre del Club -->
                                <div class="form-group mb-4">
                                    <label for="nombre" class="form-label fw-semibold">
                                        <i class="fas fa-building me-2 text-primary"></i>
                                        {{ __('Nombre del Club') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-landmark text-muted"></i>
                                        </span>
                            <input type="text" 
                                               class="form-control border-start-0 @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   required 
                                               placeholder="Ej: Club Deportivo Caracas"
                                   value="{{ $clubes->nombre }}">
                                    </div>
                                    @error('nombre')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                        </div>
                        
                                <!-- Localidad -->
                                <div class="form-group mb-4">
                                    <label for="localidad" class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                        {{ __('Localidad') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map text-muted"></i>
                                        </span>
                            <input type="text" 
                                               class="form-control border-start-0 @error('localidad') is-invalid @enderror" 
                                   id="localidad" 
                                   name="localidad" 
                                   required 
                                               placeholder="Ej: Caracas, Venezuela"
                                   value="{{ $clubes->localidad }}">
                                    </div>
                                    @error('localidad')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                        </div>
                        
                                <!-- RIF -->
                                <div class="form-group mb-4">
                                    <label for="rif" class="form-label fw-semibold">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        {{ __('RIF') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-hashtag text-muted"></i>
                                        </span>
                            <input type="text" 
                                               class="form-control border-start-0 @error('rif') is-invalid @enderror" 
                                   id="rif" 
                                   name="rif" 
                                   required 
                                               placeholder="Ej: J-12345678-9"
                                   value="{{ $clubes->rif }}">
                        </div>
                                    @error('rif')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Entrenador -->
                                <div class="form-group mb-5">
                                    <label for="entrenador_id" class="form-label fw-semibold">
                                        <i class="fas fa-user-tie me-2 text-primary"></i>
                                        {{ __('Entrenador') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-graduation-cap text-muted"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('entrenador_id') is-invalid @enderror" 
                                                id="entrenador_id" 
                                                name="entrenador_id">
                                @foreach ($entrenadores as $entrenador)
                                    <option value="{{ $entrenador->id }}" 
                                        @if($clubes->entrenador_id == $entrenador->id) selected @endif>
                                        {{ $entrenador->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                                    @error('entrenador_id')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <a href="{{ route('clubes.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        {{ __('Cancelar') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold submit-btn">
                                        <i class="fas fa-save me-2"></i>
                                        {{ __('Guardar Cambios') }}
                            </button>
                        </div>
                    </form>
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

.image-preview-card, .form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
}

.image-preview-card:hover, .form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.club-image-container {
    position: relative;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.club-logo {
    max-width: 100%;
    max-height: 200px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.club-logo:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.no-image-placeholder {
    width: 100%;
    height: 200px;
    background: #f8fafc;
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #a0aec0;
}

.club-info {
    padding: 1rem 0;
    border-top: 1px solid #e2e8f0;
    margin-top: 1rem;
}

.form-label {
    color: var(--text-dark);
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

.input-group {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.input-group:focus-within {
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.input-group-text {
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: var(--text-light);
    font-size: 0.9rem;
}

.form-control, .form-select {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: var(--white);
}

.form-control::placeholder {
    color: #a0aec0;
    font-size: 0.9rem;
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

.btn-outline-secondary {
    border: 2px solid #e2e8f0;
    color: var(--text-dark);
}

.btn-outline-secondary:hover {
    background: #f8fafc;
    border-color: var(--text-light);
    transform: translateY(-2px);
}

.info-item {
    padding: 1rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.2);
}

.info-item i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

/* Loading animation for button */
.submit-btn.loading {
    position: relative;
    color: transparent;
}

.submit-btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid var(--white);
    border-radius: 50%;
    animation: spin 1s linear infinite;
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

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Form validation styles */
.form-control.is-invalid, .form-select.is-invalid {
    border-color: #e53e3e;
    box-shadow: 0 0 0 0.2rem rgba(229, 62, 62, 0.25);
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .image-preview-card, .form-card {
        margin: 1rem 0;
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
    
    .form-control, .form-select {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn {
        padding: 0.75rem 1.25rem;
    }
    
    .club-image-container {
        min-height: 150px;
    }
    
    .club-logo {
        max-height: 150px;
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
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        width: 100%;
    }
    
    .club-image-container {
        min-height: 120px;
    }
    
    .club-logo {
        max-height: 120px;
    }
    
    .no-image-placeholder {
        height: 120px;
    }
}

/* Staggered animation for cards */
.image-preview-card {
    animation-delay: 0.1s;
}

.form-card {
    animation-delay: 0.2s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission with loading state
    const editForm = document.querySelector('.edit-form');
    const submitBtn = document.querySelector('.submit-btn');
    
    if (editForm && submitBtn) {
        editForm.addEventListener('submit', function() {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }
    
    // Input focus effects
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // Auto-hide validation messages
    const errorMessages = document.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 300);
        }, 5000);
    });
    
    // Add touch feedback for mobile
    if ('ontouchstart' in window) {
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && document.activeElement.tagName === 'INPUT') {
            const form = document.querySelector('.edit-form');
            if (form) {
                form.submit();
            }
        }
    });
    
    // Real-time validation
    const nombreInput = document.getElementById('nombre');
    const localidadInput = document.getElementById('localidad');
    const rifInput = document.getElementById('rif');
    
    // RIF format validation
    rifInput.addEventListener('input', function() {
        let value = this.value.replace(/[^A-Za-z0-9-]/g, '');
        if (value.length > 0) {
            value = value.toUpperCase();
            if (value.length >= 2) {
                value = value.slice(0, 1) + '-' + value.slice(1);
            }
        }
        this.value = value;
    });
    
    // Character counters
    function addCharacterCounter(input, maxLength) {
        const counter = document.createElement('small');
        counter.className = 'text-muted mt-1 d-block';
        counter.textContent = `${input.value.length}/${maxLength}`;
        
        input.parentElement.appendChild(counter);
        
        input.addEventListener('input', function() {
            counter.textContent = `${this.value.length}/${maxLength}`;
            if (this.value.length > maxLength * 0.8) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
            }
        });
    }
    
    if (nombreInput) addCharacterCounter(nombreInput, 100);
    if (localidadInput) addCharacterCounter(localidadInput, 100);
    
    // Image hover effects
    const clubLogo = document.getElementById('currentLogo');
    if (clubLogo) {
        clubLogo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        clubLogo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
    
    // Form change detection
    let formChanged = false;
    const formInputs = editForm.querySelectorAll('input, select');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            formChanged = true;
        });
        
        input.addEventListener('change', function() {
            formChanged = true;
        });
    });
    
    // Warn user before leaving if form has changes
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    // Remove warning when form is submitted
    editForm.addEventListener('submit', function() {
        formChanged = false;
    });
});
</script>
@endsection
