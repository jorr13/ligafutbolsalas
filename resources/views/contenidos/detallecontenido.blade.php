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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/general/jquery-3.3.1.min.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
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

        #slider {
        position: relative;
        overflow: hidden;
        }

        .slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
        }

        .slide {
        min-width: 100%;
        text-align: center;
        height: 50vh;
        }

        button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        }

        #prev {
        left: 10px;
        background: transparent;
        border: 0;
        }

        #next {
        right: 10px;
        background: transparent;
        border: 0;
        }

        .pagination {
        text-align: center;
        margin-top: 10px;
        display: flex;
        justify-content: center;
        padding-bottom: 15px;
        }

        .pagination span {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: gray;
        border-radius: 50%;
        margin: 0 5px;
        cursor: pointer;
        }

        .pagination .active {
        background-color: #3b99e0;
        }


    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg sticky-top custom-navbar shadow-sm" style="background-color: #FFFFFF !important;"> 
            <div class="container">
                <a class="navbar-brand logo" >PUNTO IL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navcol-1" aria-controls="navcol-1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                {{-- <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('exhibiciones.index') }}">Exhibiciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contenidos.index') }}">Contenidos</a>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </nav>

        <main class="content-wrapper py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Header -->
                        <div class="card rounded-1 overflow-hidden border-0 shadow-sm" style="
                            background-color: #A2CCE8;
                            overflow: auto !important;
                            max-height: 80vh;"
                        >
                            <div class="content-block p-0">
                                <div class="active align-items-center border-0 content-toggle p-3 w-100" style="background-color: #3b99e0;">
                                    <!-- Debe tener un font weight mas alto -->
                                    <h5 class="content-title text-blue-dark mb-0 flex-grow-1 fw-semibold">
                                        {{ $contenido->title }} 
                                    </h5>
                                </div>
                                @if($contenido->tipo_contenido=='0')
                                    <div class="content-collapse collapse show">
                                        <div class="p-3 text-gray-text">
                                            {!! $contenido->contenido !!}
                                        </div>
                                    </div>
                                @elseif($contenido->tipo_contenido=='2')
                                    <div id="slider">
                                        @foreach(explode('||', $contenido->contenido) as $imagen) 
                                            @php
                                                $imagen = trim($imagen); // Elimina espacios en blanco alrededor de la ruta
                                            @endphp
                                            <div class="slide active">
                                                <img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen">
                                            </div> 
                                            {{-- <div class="slide"><img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen"></div> --}}
                                        @endforeach
                                    </div>
                                @elseif($contenido->tipo_contenido=='4')
                                    
                                        @foreach($contenidoAsociado as $key => $imagenes) 
                                            <div id="micontenidoadicinal" style="    position: relative;text-align: center;">
                            
                                                <h4>{{ $imagenes->titulo }}</h4>
                                                @php
                                                    $imagen = trim($imagenes->imagen_url); // Elimina espacios en blanco alrededor de la ruta
                                                @endphp
                                               
                                                <img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen" style="    position: relative;width: auto;height: 400px;">
                                                <p>{{ $imagenes->descripcion }}</p>
                                                {{-- <div class="slide"><img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen"></div> --}}
                                            </div>
                                        @endforeach
                                @elseif($contenido->tipo_contenido=='3')
                                <div id="slider">
                                    <div class="slides">

                                        @foreach($contenidoAsociado as $key => $imagenes) 
                                            <div @if($key == "0") class="slide"@else class="slide" @endif>
                                                <h4>{{ $imagenes->titulo }}</h4>
                                                @php
                                                    $imagen = trim($imagenes->imagen_url); // Elimina espacios en blanco alrededor de la ruta
                                                @endphp
                                                
                                                <img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen" style="    width: auto;height: 400px;">
                                                <p>{{ $imagenes->descripcion }}</p>
                                                {{-- <div class="slide"><img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen"></div> --}}
                                            </div>
                                        @endforeach
                        
                                    </div>
                                    <button id="prev"><i class="fa-solid fa-chevron-left"></i></button>
                                    <button id="next"><i class="fa-solid fa-chevron-right"></i></button>
                                    <div class="pagination"></div>
                                </div>
                                @elseif($contenido->tipo_contenido=='5')
                                @foreach($contenidoAsociado as $general)
                                <div class="content-toggle" data-target="#content-{{ $general->id }}" style="background-color:#3b99e0;    background-color: #3b99e0;position: relative;display: flex;">
                                    <div class="collapse-icon me-2">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path class="vertical-line" d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <h5 class="content-title text-blue-dark mb-0 flex-grow-1 fw-semibold">{{ $general->titulo }}</h5>
                                    <i class="fas fa-chevron-down text-blue-light transition-transform"></i>

                                </div>
                   
                                    <div id="content-{{ $general->id }}" class="content-collapse collapse">
                                        <div class="p-3 text-gray-text" style="text-align: center;">
                                            <h4>{{ $general->titulo }}</h4>
                                            @php
                                                $imagen = trim($general->imagen_url); // Elimina espacios en blanco alrededor de la ruta
                                            @endphp
                                           
                                            <img src="{{ asset('storage/imagenes/' . basename($imagen)) }}" alt="Imagen" style=" width: 50%;height: auto;">
                                            <p>{{ $general->descripcion }}</p>
                                        </div>
                                    </div>
                       
                                @endforeach
                                @else
                                <video controls autoplay muted style="width: 100%;height: 400px;">
                                    @php
                                        $video = trim($contenido->contenido); // Elimina espacios en blanco alrededor de la ruta
                                    @endphp
                                    <source src="{{ asset('storage/videos/' . basename($video)) }}" type="video/mp4">
                                </video>
                                    <p style="text-align: center;">@if($contenido->descripcion_contenido !=null) {{ $contenido->descripcion_contenido }} @endif</p>
                                @endif
                            </div>
                        </div>
                
                        <!-- QR Code -->
                        {{-- <div class="card" style="display: none">
                            <div class="card-body p-4 text-center">
                                <h5 class="text-blue-dark mb-4">Código QR del Contenido</h5>
                                <div class="mb-3">
                                    <img src="data:image/png;base64,{{ $contenido->qr }}" 
                                         alt="QR {{ $contenido->title }}"
                                         class="img-fluid"
                                         style="max-width: 200px;">
                                </div>
                                <button class="btn btn-outline-success btn-sm download-qr" 
                                        data-qr="{{ $contenido->qr }}"
                                        data-title="{{ $contenido->title }}">
                                    <i class="fas fa-download me-1"></i>Descargar QR
                                </button>
                            </div>
                        </div> --}}
                    </div>
                </div>
                
            </div>
        </main>
    </div> 
    
    <!-- Scripts --> 
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
    @if($contenido->tipo_contenido=='2' || $contenido->tipo_contenido =="3")  
        <script>
            $(document).ready(function() {
            let currentIndex = 0;
            const slides = $(".slide");
            const totalSlides = slides.length;

            // Generar puntos de paginación
            for (let i = 0; i < totalSlides; i++) {
                $(".pagination").append(`<span data-index="${i}"></span>`);
            }

            updateSlider();

            $("#next").click(function() {
                if (currentIndex < totalSlides - 1) {
                currentIndex++;
                updateSlider();
                }
            });

            $("#prev").click(function() {
                if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
                }
            });

            $(".pagination span").click(function() {
                currentIndex = $(this).data("index");
                updateSlider();
            });

            function updateSlider() {
                $(".slides").css("transform", `translateX(-${currentIndex * 100}%)`);
                $(".pagination span").removeClass("active");
                $(`.pagination span:eq(${currentIndex})`).addClass("active");
            }
            });

        </script>
    
    @endif
    @if($contenido->tipo_contenido=='5')  
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.content-toggle').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('data-target');
                        const target = document.querySelector(targetId);
                        
                        // Toggle button state
                        this.classList.toggle('active');
                        
                        // Toggle collapse
                        if (target.classList.contains('show')) {
                            target.classList.remove('show');
                        } else {
                            target.classList.add('show');
                        }
                    });
                });
            });
        </script>
    @endif
<style>
    .card {
        scrollbar-width: thin;
        scrollbar-color:rgb(71, 158, 216) #A2CCE8;
    }
    
    .content-wrapper {
        background-image: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), 
                         url('{{ $exhibicion->background_image ?? asset('images/exhibitions/backgrounds/background_default.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    
        min-height: calc(100vh - 60px);
        padding: 2rem 0;
    }
    
    .content-block {
        border-radius: 8px;
        background-color: var(--white);
        box-shadow: 0 2px 4px var(--shadow-light);
        padding: clamp(0.5rem, 0.4rem + 0.5vw, 1rem);
    }
    
    .content-toggle {
        cursor: pointer;
        transition: all 0.3s ease;
        padding: clamp(0.75rem, 0.7rem + 0.3vw, 1.25rem);
    }
    
    .content-toggle:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .content-toggle:hover .content-title {
        color: var(--blue-medium) !important;
    }
    
    .content-toggle:focus {
        outline: none;
        box-shadow: none;
    }
    
    .content-title {
        font-weight: 500;
        text-transform: capitalize;
        letter-spacing: 0.6px;
        font-size: clamp(1rem, 0.95rem + 0.25vw, 1.25rem);
    }
    
    .text-gray-text {
        font-size: clamp(0.75rem, 0.65rem + 0.2vw, 1.1rem);
        line-height: clamp(1.5, 1.45 + 0.2vw, 1.7);
    }
    
    .collapse-icon {
        color: var(--blue-light);
        transition: transform 0.3s ease, color 0.3s ease;
        width: clamp(16px, 1rem + 0.2vw, 20px);
        height: clamp(16px, 1rem + 0.2vw, 20px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .content-toggle:hover .collapse-icon {
        color: var(--blue-medium);
        transform: scale(1.1);
    }
    
    .content-toggle.active .collapse-icon .vertical-line {
        transform: scaleY(0);
    }
    
    .collapse-icon svg path {
        transition: transform 0.3s ease;
    }
    
    .content-toggle.active:hover .collapse-icon {
        transform: scale(1.1);
    }
    
    .content-toggle i {
        transition: transform 0.3s ease;
        font-size: clamp(1rem, 0.95rem + 0.15vw, 1.2rem);
    }
    
    .content-toggle.active i {
        transform: rotate(-180deg);
    }
    
    .content-collapse {
        transition: all 0.3s ease-in-out;
    }
    
    .content-collapse.show {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    @media (max-width: 768px) {
        .card {
            margin: clamp(0.5rem, 0.4rem + 0.5vw, 1rem);
        }
        
        .content-title {
            font-size: 0.875rem;
        }
    }
    </style>


    <!-- Script for QR Download -->
    {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.download-qr').addEventListener('click', function() {
            const qrData = this.dataset.qr;
            const title = this.dataset.title;
            
            // Create a temporary canvas
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = function() {
                // Set canvas size to image size
                canvas.width = img.width;
                canvas.height = img.height;
                
                // Draw image on canvas
                ctx.drawImage(img, 0, 0);
                
                // Create temporary link for download
                const link = document.createElement('a');
                link.download = `QR-${title.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            };
            
            // Load the image from base64
            img.src = 'data:image/png;base64,' + qrData;
        });
    });
    </script> --}}
</body>
</html>




