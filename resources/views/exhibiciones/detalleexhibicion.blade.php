@extends('layouts.public')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="text-blue-dark mb-0 mx-2 mb-md-4">Contenido</h2>
        <div class="card rounded-1 overflow-hidden border-0 shadow-sm" style="
            background-color: #A2CCE8;
            overflow: auto !important;
            max-height: 60vh;"
        >
            @if($contenidoGeneral->isNotEmpty())
                @foreach ($contenidoGeneral as $general)
                <div class="content-block p-0">
                    <button class="content-toggle w-100 text-start border-0 p-3 d-flex align-items-center" 
                            data-target="#content-{{ $general->id }}"
                            style="background-color: #3b99e0;">
                        <div class="collapse-icon me-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="vertical-line" d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <!-- Debe tener un font weight mas alto -->
                        <h5 class="content-title text-blue-dark mb-0 flex-grow-1 fw-semibold">{{ $general->title }}</h5>
                        <i class="fas fa-chevron-down text-blue-light transition-transform"></i>
                    </button>
                    <div id="content-{{ $general->id }}" class="content-collapse collapse">
                        <div class="p-3 text-gray-text">
                            {!! $general->contenido !!}
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            @if($contenidoDependiente->isNotEmpty())
                @foreach ($contenidoDependiente as $dependiente)
                <div class="content-block p-0">
                    <!-- los botones deben tener un fondo azul claro -->
                    <button class="content-toggle w-100 text-start border-0 bg-info p-3 d-flex align-items-center"
                            data-target="#content-{{ $dependiente->id }}">
                        <div class="collapse-icon me-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="vertical-line" d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <!-- Debe tener un font weight mas alto -->
                        <h5 class="content-title text-blue-dark mb-0 flex-grow-1 fw-semibold">{{ $dependiente->title }}</h5>
                        <i class="fas fa-chevron-down text-blue-light transition-transform"></i>
                    </button>
                    <div id="content-{{ $dependiente->id }}" class="content-collapse collapse">
                        <div class="p-3 text-gray-text">
                            {!! $dependiente->contenido !!}
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            @if($contenidoGeneral->isEmpty() && $contenidoDependiente->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3 d-block"></i>
                <p class="text-muted">No hay contenido disponible para esta exhibición</p>
            </div>
            @endif
        </div>
    </div>
</div>

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
@endsection


