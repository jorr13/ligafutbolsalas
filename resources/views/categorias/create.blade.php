@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-tags"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Nueva Categoría') }}</h2>
                <p class="text-muted mb-0">{{ __('Registra una nueva categoría en la Liga de Fútbol Sala') }}</p>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-lg form-card">
                <div class="card-body p-5">
                    <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
                        @csrf
                        
                        <!-- Nombre de la Categoría -->
                        <div class="form-group mb-5">
                            <label for="nombre" class="form-label fw-semibold">
                                <i class="fas fa-tag me-2 text-primary"></i>
                                {{ __('Nombre de la Categoría') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-tags text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       required 
                                       placeholder="Ej: Sub-15, Sub-17, Sub-20"
                                       value="{{ old('nombre') }}">
                            </div>
                            @error('nombre')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold submit-btn">
                                <i class="fas fa-save me-2"></i>
                                {{ __('Guardar Categoría') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Section -->
            
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

.form-control {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
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
.form-control.is-invalid {
    border-color: #e53e3e;
    box-shadow: 0 0 0 0.2rem rgba(229, 62, 62, 0.25);
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-card {
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
    
    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn {
        padding: 0.75rem 1.25rem;
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission with loading state
    const createForm = document.querySelector('.create-form');
    const submitBtn = document.querySelector('.submit-btn');
    
    if (createForm && submitBtn) {
        createForm.addEventListener('submit', function() {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }
    
    // Input focus effects
    const inputs = document.querySelectorAll('.form-control');
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
            const form = document.querySelector('.create-form');
            if (form) {
                form.submit();
            }
        }
    });
    
    // Character counter
    const nombreInput = document.getElementById('nombre');
    if (nombreInput) {
        const counter = document.createElement('small');
        counter.className = 'text-muted mt-1 d-block';
        counter.textContent = `${nombreInput.value.length}/50`;
        
        nombreInput.parentElement.appendChild(counter);
        
        nombreInput.addEventListener('input', function() {
            counter.textContent = `${this.value.length}/50`;
            if (this.value.length > 40) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
            }
        });
    }
});
</script>
@endsection
