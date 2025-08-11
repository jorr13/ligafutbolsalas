<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Liga de Futbol Sala</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        .custom-navbar {
            background-color: var(--white) !important;
            transition: all 0.3s ease-in-out;
        }
        
        .custom-navbar.scrolled {
            box-shadow: 0 2px 10px var(--shadow-light);
        }
        
        .navbar-brand.logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--blue-dark);
            letter-spacing: 1px;
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--gray-dark) !important;
            margin: 0 10px;
            padding: 8px 0;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--blue-light);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: var(--white);
                padding: 1rem;
                border-radius: 8px;
                margin-top: 0.5rem;
                box-shadow: 0 4px 6px var(--shadow-light);
            }
            
            .nav-link {
                margin: 8px 0;
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
        <nav class="navbar navbar-expand-lg sticky-top custom-navbar shadow-sm" style="background-color: #FFFFFF !important;"> 
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home') }}" >Liga de Futbol Sala</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navcol-1" aria-controls="navcol-1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        
                        
                        @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @else
                        @if(auth()->user()->rol_id=="entrenador")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('jugadores.index') }}">Mis Jugadores</a>
                            </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clubes.index') }}">Mi Club</a> {{--pendientecambiaraqui--}}
                        </li>
               
                       
                        @endif
                        @if(auth()->user()->rol_id=="administrador")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('clubes.index') }}">Clubes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('categorias.index') }}">Categorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a>
                            </li>
                        @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar sesion') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
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
    </script>
</body>
</html>
