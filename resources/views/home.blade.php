@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary">
                <div class="card-body text-center p-5">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="">
                            <img src="{{ asset('imagen/logoligafutbolsalas.png') }}" alt="Logo" style="width: auto; height: 150px;">
                        </div>
                        <div>
                            <h1 class="text-white mb-1 fw-bold">{{ __('¡Bienvenido!') }}</h1>
                            <p class="text-white-50 mb-0 fs-5">{{ __('Panel de Control - Liga de Fútbol Sala') }}</p>
                        </div>
                    </div>
                    
                    <div class="row g-3 mt-4"  >
                        <div class="col-6 col-md-3">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <div class="d-flex align-items-center">
                                                                         <i class="fas fa-user-circle text-dark fs-4 me-2"></i>
                                     <div>
                                         <h5 class="text-dark mb-0 fw-bold">{{ auth()->user()->name }}</h5>
                                         <small class="text-dark">{{ ucfirst(auth()->user()->rol_id) }}</small>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <div class="d-flex align-items-center">
                                                                         <i class="fas fa-calendar-day text-dark fs-4 me-2"></i>
                                     <div>
                                         <h5 class="text-dark mb-0 fw-bold">{{ now()->format('d/m/Y') }}</h5>
                                         @php
                                             \Carbon\Carbon::setLocale('es');
                                         @endphp
                                         <small class="text-dark">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</small>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <div class="d-flex align-items-center">
                                                                         <i class="fas fa-clock text-dark fs-4 me-2"></i>
                                     <div>
                                         <h5 class="text-dark mb-0 fw-bold">{{ \Carbon\Carbon::now()->format('g:i A'); }}</h5>
                                         <small class="text-dark">Hora actual</small>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <div class="d-flex align-items-center">
                                                                         <i class="fas fa-server text-dark fs-4 me-2"></i>
                                     <div>
                                         <h5 class="text-dark mb-0 fw-bold">Sistema</h5>
                                         <small class="text-dark">Activo</small>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row g-4" style="justify-content: center;">
        @if(auth()->user()->rol_id=="entrenador")
            <!-- Entrenador Dashboard -->
            <div class="col-12">
                <h3 class="mb-4 fw-bold text-primary">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Panel de Entrenador
                </h3>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('jugadores.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-friends text-primary fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Mis Jugadores</h5>
                        <p class="text-muted small mb-0">Gestionar plantilla</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('entrenador.clubes.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-landmark text-info fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Clubes</h5>
                        <p class="text-muted small mb-0">Ver todos los clubes</p>
                    </div>
                </a>
            </div>
        @endif
        @if(auth()->user()->rol_id=="arbitro")
            <!-- Entrenador Dashboard -->
            <div class="col-12">
                <h3 class="mb-4 fw-bold text-primary">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Panel de Arbitro
                </h3>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('entrenador.clubes.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-landmark text-info fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Clubes</h5>
                        <p class="text-muted small mb-0">Ver todos los clubes</p>
                    </div>
                </a>
            </div>
        @endif

        @if(auth()->user()->rol_id=="administrador")
            <!-- Administrador Dashboard -->
            <div class="col-12">
                <h3 class="mb-4 fw-bold text-primary">
                    <i class="fas fa-user-shield me-2"></i>
                    Panel de Administración
                </h3>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('clubes.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-landmark text-primary fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Clubes</h5>
                        <p class="text-muted small mb-0">Gestionar clubes</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('categorias.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-tags text-success fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Categorías</h5>
                        <p class="text-muted small mb-0">Gestionar categorías</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('entrenadores.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap text-info fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Entrenadores</h5>
                        <p class="text-muted small mb-0">Gestionar entrenadores</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('arbitros.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-flag-checkered text-info fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Arbitros</h5>
                        <p class="text-muted small mb-0">Gestionar arbitros</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('jugadores.indexpendientes') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card position-relative">
                    @if($jugadores > 0)
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger rounded-pill fs-6 px-2 py-1">
                                {{$jugadores}}+
                            </span>
                        </div>
                    @endif
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-hourglass-half text-warning fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Jugadores Pendientes</h5>
                        <p class="text-muted small mb-0">Revisar solicitudes</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('usuarios.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none quick-action-card">
                    <div class="card-body text-center p-4">
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-users-cog text-secondary fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2 fw-bold">Usuarios</h5>
                        <p class="text-muted small mb-0">Gestionar usuarios</p>
                    </div>
                </a>
            </div>
        @endif
    </div>

    <!-- Footer Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-center">
                            
                                <span class="text-muted">©Copy Right {{ now()->format('Y') }} Liga de Fútbol Sala. Todos los derechos reservados.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #8F0000 0%, #6B0000 100%);
}

.bg-purple {
    background-color: #8F0000;
}

.text-purple {
    color: #8F0000;
}

.quick-action-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.quick-action-card .card-body {
    transition: all 0.3s ease;
}

.quick-action-card:hover .card-body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.quick-action-card:hover .rounded-circle {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.quick-action-card .rounded-circle {
    transition: all 0.3s ease;
}

.quick-action-card .fas {
    transition: all 0.3s ease;
}

.quick-action-card:hover .fas {
    transform: scale(1.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    h1 {
        font-size: 1.5rem !important;
    }
    
    h3 {
        font-size: 1.25rem !important;
    }
    
    .fs-1 {
        font-size: 2rem !important;
    }
    
    .fs-2 {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .bg-gradient-primary .card-body {
        padding: 2rem 1rem !important;
    }
    
    .row.g-3 > div {
        margin-bottom: 1rem;
    }
    
    .quick-action-card {
        margin-bottom: 1rem;
    }
}

/* Animation for cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.quick-action-card {
    animation: fadeInUp 0.6s ease-out;
}

.quick-action-card:nth-child(1) { animation-delay: 0.1s; }
.quick-action-card:nth-child(2) { animation-delay: 0.2s; }
.quick-action-card:nth-child(3) { animation-delay: 0.3s; }
.quick-action-card:nth-child(4) { animation-delay: 0.4s; }
.quick-action-card:nth-child(5) { animation-delay: 0.5s; }
.quick-action-card:nth-child(6) { animation-delay: 0.6s; }
.quick-action-card:nth-child(7) { animation-delay: 0.7s; }
.quick-action-card:nth-child(8) { animation-delay: 0.8s; }

/* Touch feedback for mobile */
@media (hover: none) {
    .quick-action-card:active {
        transform: scale(0.98);
    }
    
    .quick-action-card:active .rounded-circle {
        transform: scale(1.05);
    }
}

/* Icon pulse animation for pending players */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.quick-action-card .fa-hourglass-half {
    animation: pulse 2s infinite;
}

/* Gradient text effect for headers */
.bg-gradient-primary h1,
.bg-gradient-primary h4 {
    background: linear-gradient(45deg, #ffffff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Loading animation for status alert */
.alert {
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Improved contrast for dark text on white backgrounds */
.bg-white.bg-opacity-20 {
    background-color: rgba(255, 255, 255, 0.9) !important;
    backdrop-filter: blur(10px);
}

.bg-white.bg-opacity-20 .text-dark {
    color: #000000 !important;
    font-weight: 600;
}

.bg-white.bg-opacity-20 small {
    color: #333333 !important;
    font-weight: 500;
}

/* Enhanced readability for header cards */
.bg-white.bg-opacity-20 .fas {
    color: #000000 !important;
    opacity: 0.8;
}

.bg-white.bg-opacity-20:hover .fas {
    opacity: 1;
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add touch feedback for mobile devices
    const cards = document.querySelectorAll('.quick-action-card');
    
    cards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });
        
        card.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
    
    // Add loading animation to cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Add icon hover effects
    const icons = document.querySelectorAll('.quick-action-card .fas');
    icons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2) rotate(5deg)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });
    
    // Add real-time clock update
    function updateClock() {
        const now = new Date();
        const timeElement = document.querySelector('.fa-clock').parentElement.querySelector('h4');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        }
    }
    
    // Update clock every second
    setInterval(updateClock, 1000);
});
</script>
@endsection
