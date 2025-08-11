<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $exhibicion->title ?? 'Punto IL' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <style>
        body {
            background: var(--gradient-white);
            color: var(--gray-text);
        }
        .public-navbar {
            background-color: var(--white);
            border-bottom: 1px solid var(--shadow-light);
        }
        .public-navbar .navbar-brand {
            font-size: 1.1rem;
            color: var(--blue-dark);
            font-weight: 600;
        }
        .content-wrapper {
            min-height: calc(100vh - 60px);
            padding: 2rem 0;
        }
        footer {
            background: var(--gradient-footer) !important;
            color: var(--gray-text);
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Simple Public Navigation -->
        <nav class="navbar navbar-expand-lg public-navbar shadow-lg" style="background-color: #FFFFFF !important;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <i class="fas fa-museum me-2"></i>
      
                    Liga de Futbol Sala
                    
                </a>
            </div>
        </nav>

        <main class="content-wrapper">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- Simple Footer -->
        <footer class="py-3 bg-white border-top">
            <div class="container">
                <div class="text-center text-muted">
                    <small style="font-size: 0.5rem;">&copy; {{ date('Y') }} Liga de futbol Salas. Todos los derechos reservados.</small>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/general/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/general/bootstrap.min.js') }}"></script>
</body>
</html> 