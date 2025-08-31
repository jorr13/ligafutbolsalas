@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <!-- Login Card -->
                <div class="card border-0 shadow-lg login-card">
                    <div class="card-body p-5">
                        <!-- Header Section -->
                        <div class="text-center mb-4">
                            <div class="login-icon mb-3">
                                <i class="fas fa-futbol"></i>
                            </div>
                            <h2 class="fw-bold text-primary mb-2">{{ __('Iniciar Sesión') }}</h2>
                            <p class="text-muted mb-0">{{ __('Liga de Fútbol Sala de Caracas') }}</p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf

                            <!-- Email Field -->
                            <div class="form-group mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    {{ __('Correo Electrónico') }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-at text-muted"></i>
                                    </span>
                                    <input id="email" type="email" 
                                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autocomplete="email" autofocus
                                           placeholder="tu@email.com">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-primary"></i>
                                    {{ __('Contraseña') }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-key text-muted"></i>
                                    </span>
                                    <input id="password" type="password" 
                                           class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="current-password"
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

                            <!-- Remember Me Checkbox -->
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium" for="remember">
                                        <i class="fas fa-check-circle me-2 text-primary"></i>
                                        {{ __('Recordarme') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary w-100 btn-lg fw-semibold login-btn">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    {{ __('Iniciar Sesión') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="text-center mt-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-center">
                      
                                <span class="text-muted" style="color:white !important;">©Copy Right {{ now()->format('Y') }} Liga de Fútbol Sala. Todos los derechos reservados.</span>
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

body {
    background: var(--gradient-primary);
    min-height: 100vh;
    position: relative;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
    z-index: -1;
}

.login-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
}

.login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.login-icon {
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

.login-card:hover .login-icon {
    transform: scale(1.1);
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

.btn-primary {
    background: var(--gradient-primary);
    border: none;
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-primary:active {
    transform: translateY(0);
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    border-radius: 6px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.form-check-input:checked {
    background: var(--gradient-primary);
    border-color: var(--primary-color);
}

.form-check-label {
    color: var(--text-dark);
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-check-label:hover {
    color: var(--primary-color);
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.85rem;
    font-weight: 500;
}

.feature-item {
    padding: 1rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.2);
}

.feature-item i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
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

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-card {
        margin: 1rem;
        border-radius: 16px;
    }
    
    .login-icon {
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
    
    .btn-primary {
        padding: 0.75rem 1.5rem;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0 1rem;
    }
    
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .feature-item {
        padding: 0.75rem;
    }
    
    .feature-item i {
        font-size: 1.25rem;
    }
}

/* Loading animation for button */
.login-btn.loading {
    position: relative;
    color: transparent;
}

.login-btn.loading::after {
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

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Password toggle button */
#togglePassword {
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: var(--text-light);
    transition: all 0.3s ease;
}

#togglePassword:hover {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
}

/* Form validation styles */
.form-control.is-invalid {
    border-color: #e53e3e;
    box-shadow: 0 0 0 0.2rem rgba(229, 62, 62, 0.25);
}

.form-control.is-valid {
    border-color: #38a169;
    box-shadow: 0 0 0 0.2rem rgba(56, 161, 105, 0.25);
}
.navbar{
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    }
    
    // Form submission with loading state
    const loginForm = document.querySelector('.login-form');
    const loginBtn = document.querySelector('.login-btn');
    
    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function() {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;
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
    
    // Add floating labels effect
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach(group => {
        const input = group.querySelector('.form-control');
        const label = group.querySelector('.form-label');
        
        if (input && label) {
            if (input.value) {
                label.classList.add('active');
            }
            
            input.addEventListener('input', function() {
                if (this.value) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        }
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
            const form = document.querySelector('.login-form');
            if (form) {
                form.submit();
            }
        }
    });
});
</script>
@endsection
