@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Nuevo Usuario') }}</h2>
                <p class="text-muted mb-0">{{ __('Registra un nuevo usuario en el sistema') }}</p>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-lg form-card">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('usuarios.store') }}" class="create-form">
                        @csrf
                        
                        <!-- Nombre -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                {{ __('Nombre Completo') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input id="name" 
                                       type="text" 
                                       class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name" 
                                       autofocus
                                       placeholder="Ej: Juan Carlos Pérez">
                            </div>
                            @error('name')
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
                                <input id="email" 
                                       type="email" 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email"
                                       placeholder="Ej: usuario@email.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="form-group mb-4">
                            <label for="rol_id" class="form-label fw-semibold">
                                <i class="fas fa-user-tag me-2 text-primary"></i>
                                {{ __('Rol') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-shield-alt text-muted"></i>
                                </span>
                                <select name="rol_id" 
                                        id="rol_id" 
                                        class="form-select border-start-0 @error('rol_id') is-invalid @enderror">
                                    <option value="" selected disabled>{{ __('Seleccione un rol...') }}</option>
                                    <option value="administrador" {{ old('rol_id') == 'administrador' ? 'selected' : '' }}>{{ __('Administrador') }}</option>
                                    <option value="entrenador" {{ old('rol_id') == 'entrenador' ? 'selected' : '' }}>{{ __('Entrenador') }}</option>
                                    <option value="arbitro" {{ old('rol_id') == 'arbitro' ? 'selected' : '' }}>{{ __('arbitro') }}</option>
                                </select>
                            </div>
                            @error('rol_id')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>
                                {{ __('Contraseña') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input id="password" 
                                       type="password" 
                                       class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="••••••••">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-group mb-5">
                            <label for="password-confirm" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>
                                {{ __('Confirmar Contraseña') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input id="password-confirm" 
                                       type="password" 
                                       class="form-control border-start-0" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="••••••••">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye" id="eyeConfirmIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold submit-btn">
                                <i class="fas fa-save me-2"></i>
                                {{ __('Guardar Usuario') }}
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

.btn-outline-danger {
    border: 2px solid #fed7d7;
    color: #e53e3e;
}

.btn-outline-danger:hover {
    background: #e53e3e;
    color: var(--white);
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
    
    .form-control, .form-select {
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
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('password-confirm');
    const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    }
    
    if (toggleConfirmPassword && confirmPasswordInput) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            eyeConfirmIcon.classList.toggle('fa-eye');
            eyeConfirmIcon.classList.toggle('fa-eye-slash');
        });
    }
    
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
            const form = document.querySelector('.create-form');
            if (form) {
                form.submit();
            }
        }
    });
    
    // Character counter
    const nameInput = document.getElementById('name');
    if (nameInput) {
        const counter = document.createElement('small');
        counter.className = 'text-muted mt-1 d-block';
        counter.textContent = `${nameInput.value.length}/100`;
        
        nameInput.parentElement.appendChild(counter);
        
        nameInput.addEventListener('input', function() {
            counter.textContent = `${this.value.length}/100`;
            if (this.value.length > 80) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
            }
        });
    }
    
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        const strengthIndicator = document.createElement('div');
        strengthIndicator.className = 'password-strength mt-2';
        strengthIndicator.innerHTML = `
            <div class="strength-bar">
                <div class="strength-fill" id="strengthFill"></div>
            </div>
            <small class="strength-text" id="strengthText">Contraseña débil</small>
        `;
        
        passwordInput.parentElement.appendChild(strengthIndicator);
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            updateStrengthIndicator(strength);
        });
    }
    
    function calculatePasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 8) strength += 25;
        if (/[a-z]/.test(password)) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        
        return strength;
    }
    
    function updateStrengthIndicator(strength) {
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        
        if (strengthFill && strengthText) {
            strengthFill.style.width = strength + '%';
            
            if (strength <= 25) {
                strengthFill.style.backgroundColor = '#e53e3e';
                strengthText.textContent = 'Contraseña débil';
                strengthText.className = 'strength-text text-danger';
            } else if (strength <= 50) {
                strengthFill.style.backgroundColor = '#f6ad55';
                strengthText.textContent = 'Contraseña regular';
                strengthText.className = 'strength-text text-warning';
            } else if (strength <= 75) {
                strengthFill.style.backgroundColor = '#68d391';
                strengthText.textContent = 'Contraseña buena';
                strengthText.className = 'strength-text text-success';
            } else {
                strengthFill.style.backgroundColor = '#38a169';
                strengthText.textContent = 'Contraseña excelente';
                strengthText.className = 'strength-text text-success';
            }
        }
    }
});

// Add password strength styles
const style = document.createElement('style');
style.textContent = `
    .password-strength {
        margin-top: 0.5rem;
    }
    
    .strength-bar {
        width: 100%;
        height: 4px;
        background-color: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 0.25rem;
    }
    
    .strength-fill {
        height: 100%;
        background-color: #e53e3e;
        transition: all 0.3s ease;
        width: 0%;
    }
    
    .strength-text {
        font-size: 0.75rem;
        font-weight: 500;
    }
`;
document.head.appendChild(style);
</script>
@endsection
