<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Liga de Futbol Sala de Caracas</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
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

        .custom-navbar {
            background: var(--white) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0.75rem 0;
        }
        
        .custom-navbar.scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
        }
        
        .navbar-brand.logo {
            font-weight: 800;
            font-size: 1.75rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-brand.logo:hover {
            transform: scale(1.05);
        }
        
        .navbar-brand.logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .navbar-brand.logo:hover::after {
            width: 100%;
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--text-dark) !important;
            margin: 0 12px;
            padding: 12px 16px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            border-radius: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .nav-link:hover::before {
            opacity: 0.1;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: all 0.3s ease;
            border-radius: 1px;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 60%;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.75rem;
            border-radius: 12px;
            background: rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-toggler:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: scale(1.05);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            outline: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(102, 126, 234, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                padding: 1.5rem;
                border-radius: 16px;
                margin-top: 1rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .nav-link {
                margin: 8px 0;
                padding: 16px 20px;
                border-radius: 12px;
                text-align: center;
                font-size: 1rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            
            .nav-link:hover {
                background: var(--gradient-primary);
                color: var(--white) !important;
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            }
            
            .nav-link::after {
                display: none;
            }
            
            .dropdown-menu {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                margin-top: 0.5rem;
            }
            
            .user-avatar {
                display: none;
            }
        }
        
        /* Dropdown Styles */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 250px;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 1000 !important;
            transform: none !important;
        }
        
        .dropdown-menu.show {
            display: block !important;
            animation: slideDown 0.3s ease forwards;
        }
        
        .dropdown-header {
            padding: 1rem 1.5rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
            margin: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 0.5rem;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: var(--gradient-primary);
            color: var(--white);
            transform: translateX(5px);
        }
        
        .dropdown-divider {
            margin: 0.5rem 1rem;
            border-color: rgba(102, 126, 234, 0.1);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.9rem;
        }
        
        /* Animation for navbar */
        .navbar-nav .nav-item {
            opacity: 0;
            animation: slideInDown 0.6s ease forwards;
        }
        
        .navbar-nav .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .navbar-nav .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .navbar-nav .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .navbar-nav .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .navbar-nav .nav-item:nth-child(5) { animation-delay: 0.5s; }
        
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
        
        /* Mobile optimizations */
        @media (max-width: 576px) {
            .navbar-brand.logo {
                font-size: 1.25rem;
            }
            
            .navbar-brand.logo i {
                font-size: 1rem;
            }
            
            .nav-link {
                padding: 14px 16px;
                font-size: 0.95rem;
            }
            
            .dropdown-menu {
                min-width: 200px;
                margin: 0.5rem 1rem;
            }
        }

        /* Table action buttons styles */
        .table .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            white-space: nowrap;
        }

        .table .d-flex.gap-2 {
            flex-wrap: nowrap;
        }

        .table td {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table .actions-column {
            min-width: 260px;
            width: auto;
        }

        /* Custom button styles */
        .btn-outline-primary {
            border-color: var(--blue-dark);
            color: var(--blue-dark);
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-button);
            border-color: var(--blue-dark);
            color: var(--white);
        }

        .btn-outline-primary:hover, .btn-outline-info:hover,
        .btn-outline-warning:hover, .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px var(--shadow-light);
        }

        /* Table responsive styles */
        @media (max-width: 1200px) {
            .table .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
            
            .table .d-flex.gap-2 {
                gap: 0.25rem !important;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg sticky-top custom-navbar shadow-sm"> 
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo/logoligafutbolsalas.png') }}" alt="Logo" style="width: auto; height: 50px;">
                    Liga de Fútbol Sala de Caracasssss
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navcol-1" aria-controls="navcol-1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto align-items-center">
                        
                        @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    {{ __('Login') }}
                                </a>
                            </li>
                        @endif

                        @else
                        @if(auth()->user()->rol_id=="entrenador")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('jugadores.index') }}">
                                    <i class="fas fa-users me-2"></i>
                                    Mis Jugadores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('clubes.index') }}">
                                    <i class="fas fa-landmark me-2"></i>
                                    Mi Club
                                </a>
                            </li>
                        @endif
                        
                        @if(auth()->user()->rol_id=="administrador")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('clubes.index') }}">
                                    <i class="fas fa-building me-2"></i>
                                    Clubes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('categorias.index') }}">
                                    <i class="fas fa-tags me-2"></i>
                                    Categorías
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuarios.index') }}">
                                    <i class="fas fa-user-shield me-2"></i>
                                    Usuarios
                                </a>
                            </li>
                        @endif
                        
                        <!-- User Profile Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar me-2">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <div class="dropdown-header">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                <i class="fas fa-user-circle fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                                <small class="text-muted">{{ ucfirst(auth()->user()->rol_id) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        {{ __('Cerrar sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                        
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content-wrapper py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div> 
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        // Add shadow on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.custom-navbar');
            if (window.scrollY > 0) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Add hover effects for nav links
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                link.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Add active state for current page
            const currentPath = window.location.pathname;
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    link.style.background = 'var(--gradient-primary)';
                    link.style.color = 'var(--white) !important';
                }
            });
            
            // Add touch feedback for mobile
            if ('ontouchstart' in window) {
                navLinks.forEach(link => {
                    link.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.98)';
                    });
                    
                    link.addEventListener('touchend', function() {
                        this.style.transform = 'scale(1)';
                    });
                });
            }
            
                         // Smooth dropdown animations - Fixed version
             const dropdowns = document.querySelectorAll('.dropdown-toggle');
             dropdowns.forEach(dropdown => {
                 dropdown.addEventListener('click', function(e) {
                     // Let Bootstrap handle the dropdown toggle
                     const menu = this.nextElementSibling;
                     
                     // Add animation after Bootstrap toggles the class
                     setTimeout(() => {
                         if (menu.classList.contains('show')) {
                             menu.style.animation = 'slideDown 0.3s ease forwards';
                         } else {
                             menu.style.animation = 'slideUp 0.3s ease forwards';
                         }
                     }, 10);
                 });
             });
             
             // Fix dropdown menu positioning and behavior
             const dropdownMenus = document.querySelectorAll('.dropdown-menu');
             dropdownMenus.forEach(menu => {
                 // Remove any inline styles that might interfere
                 menu.style.animation = '';
                 
                 // Add proper positioning
                 menu.style.position = 'absolute';
                 menu.style.top = '100%';
                 menu.style.right = '0';
                 menu.style.zIndex = '1000';
             });
             
             // Handle dropdown close when clicking outside
             document.addEventListener('click', function(e) {
                 const dropdowns = document.querySelectorAll('.dropdown');
                 dropdowns.forEach(dropdown => {
                     const toggle = dropdown.querySelector('.dropdown-toggle');
                     const menu = dropdown.querySelector('.dropdown-menu');
                     
                     if (!dropdown.contains(e.target)) {
                         if (menu.classList.contains('show')) {
                             toggle.classList.remove('show');
                             menu.classList.remove('show');
                             menu.style.animation = 'slideUp 0.3s ease forwards';
                             setTimeout(() => {
                                 menu.style.display = 'none';
                             }, 300);
                         }
                     }
                 });
             });
        });
        
                 // Add CSS animations
         const style = document.createElement('style');
         style.textContent = `
             @keyframes slideDown {
                 from {
                     opacity: 0;
                     transform: translateY(-10px) scale(0.95);
                 }
                 to {
                     opacity: 1;
                     transform: translateY(0) scale(1);
                 }
             }
             
             @keyframes slideUp {
                 from {
                     opacity: 1;
                     transform: translateY(0) scale(1);
                 }
                 to {
                     opacity: 0;
                     transform: translateY(-10px) scale(0.95);
                 }
             }
             
             .nav-link.active {
                 background: var(--gradient-primary) !important;
                 color: var(--white) !important;
                 box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
             }
             
             /* Ensure dropdown works properly */
             .dropdown {
                 position: relative;
             }
             
             .dropdown-toggle::after {
                 display: inline-block;
                 margin-left: 0.255em;
                 vertical-align: 0.255em;
                 content: "";
                 border-top: 0.3em solid;
                 border-right: 0.3em solid transparent;
                 border-bottom: 0;
                 border-left: 0.3em solid transparent;
                 transition: transform 0.3s ease;
             }
             
             .dropdown-toggle.show::after {
                 transform: rotate(180deg);
             }
         `;
         document.head.appendChild(style);
    </script>
</body>
</html>
