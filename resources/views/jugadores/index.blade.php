@extends('layouts.app')

@section('styles')
<style>
    /* Estilos personalizados para la tabla */
    .table th {
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
    }
    
    .jugador-row {
        transition: all 0.2s ease-in-out;
        border-left: 3px solid transparent;
    }
    
    .jugador-row:hover {
        border-left-color: #007bff;
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    .highlight-row {
        background-color: #fff3cd !important;
        border-left-color: #ffc107;
    }
    
    .badge {
        font-weight: 500;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
    }
    
    .btn-group .btn:first-child {
        margin-left: 0;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    /* Animaciones para las estadísticas */
    .card-body h3 {
        transition: all 0.3s ease;
    }
    
    .card-body h3:hover {
        transform: scale(1.05);
    }
    
    /* Estilos para el input de búsqueda */
    #searchInput {
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    
    #searchInput:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-color: #007bff;
    }
    
    /* Estilos para las imágenes de perfil */
    .jugador-avatar {
        transition: all 0.3s ease;
    }
    
    .jugador-avatar:hover {
        transform: scale(1.05);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }
        
        .btn-group .btn {
            margin: 1px 0;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        /* Header responsive */
        .card-body .row {
            flex-direction: column;
        }
        
        .card-body .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .card-body .row.text-center {
            margin-top: 1rem;
        }
        
        /* Tabla responsive */
        .table th, .table td {
            padding: 0.75rem 0.5rem;
        }
        
        .table th {
            font-size: 0.85rem;
        }
        
        .table td {
            font-size: 0.8rem;
        }
        
        /* Ocultar columnas menos importantes en móvil */
        .table th:nth-child(2),
        .table td:nth-child(2),
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: none;
        }
        
        /* Botones más pequeños en móvil */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        /* Búsqueda responsive */
        .input-group {
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        /* Header de tabla responsive */
        .card-header .row {
            flex-direction: column;
        }
        
        .card-header .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .card-header .text-end {
            text-align: left !important;
        }
    }
    
    @media (max-width: 576px) {
        /* Ajustes para pantallas muy pequeñas */
        .container-fluid {
            padding: 1rem 0.5rem;
        }
        
        .card {
            margin: 0;
            border-radius: 0;
        }
        
        .table-responsive {
            border: none;
        }
        
        /* Botones apilados verticalmente */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .btn-group .btn {
            width: 100%;
            margin: 0;
        }
        
        /* Información del jugador más compacta */
        .d-flex.align-items-center {
            flex-direction: column;
            text-align: center;
        }
        
        .position-relative.me-3 {
            margin: 0 0 0.5rem 0;
        }
        
        /* Estadísticas más compactas */
        .card-body h3 {
            font-size: 1.5rem;
        }
        
        .card-body small {
            font-size: 0.75rem;
        }
        
        /* Ocultar más columnas en pantallas muy pequeñas */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }
        
        /* Indicador de swipe */
        .table-responsive::before {
            content: "← Desliza para ver más →";
            display: block;
            text-align: center;
            color: #6c757d;
            font-size: 0.75rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Mejorar la experiencia de scroll */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }
        
        /* Botones más táctiles */
        .btn {
            min-height: 44px;
            touch-action: manipulation;
        }
        
        /* Mejorar contraste en móvil */
        .text-muted {
            color: #495057 !important;
        }
        
        /* Mejorar accesibilidad */
        .btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
        }
        
        /* Indicador de búsqueda */
        .table-responsive.searching::after {
            content: "🔍 Buscando...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            z-index: 1000;
        }
        
        /* Efecto de touch */
        .btn.touch-active {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }
        
        /* Mejorar la experiencia de scroll horizontal */
        .table-responsive {
            scroll-snap-type: x mandatory;
        }
        
        .table-responsive .table {
            scroll-snap-align: start;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header con estadísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="h4 mb-1 text-primary fw-bold">
                                <i class="fas fa-users me-2"></i>Gestión de Jugadores
                            </h2>
                            <p class="text-muted mb-0">Administra todos los jugadores de la liga</p>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h3 class="h5 mb-1 text-success">{{ $jugadores->where('status', 'activo')->count() }}</h3>
                                        <small class="text-muted">Activos</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h3 class="h5 mb-1 text-warning">{{ $jugadores->where('status', 'pendiente')->count() }}</h3>
                                        <small class="text-muted">Pendientes</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h3 class="h5 mb-1 text-info">{{ $jugadores->count() }}</h3>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla mejorada -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>Lista de Jugadores
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar jugador...">
                        </div>
                        <a href="{{ route('jugadores.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nuevo Jugador
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="jugadoresTable">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-user-circle text-muted me-2"></i>Jugador
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-id-badge text-muted me-2"></i>Cédula
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-phone text-muted me-2"></i>Contacto
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-shield-alt text-muted me-2"></i>Club
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-circle text-muted me-2"></i>Estado
                        </th>
                        <th class="border-0 py-3 px-4 text-end">
                            <i class="fas fa-cogs text-muted me-2"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jugadores as $jugador)
                    <tr class="jugador-row">
                        <td class="py-3 px-4">
                            <div class="d-flex align-items-center">
                                <div class="position-relative me-3">
                                    <img src="{{ $jugador->foto_identificacion ?? '/images/default-avatar.png' }}" 
                                         alt="Foto de {{ $jugador->nombre }}" 
                                         class="rounded-circle border-2 border-light shadow-sm jugador-avatar" 
                                         style="width: 45px; height: 45px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 end-0 bg-{{ $jugador->status == 'activo' ? 'success' : 'warning' }} rounded-circle border-2 border-white" 
                                         style="width: 12px; height: 12px;"></div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $jugador->nombre }}</h6>
                                    <small class="text-muted">{{ $jugador->email ?? 'Sin email' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="fw-medium text-dark">{{ $jugador->cedula }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-dark">
                                    <i class="fas fa-phone text-muted me-1"></i>{{ $jugador->telefono ?? 'No especificado' }}
                                </span>
                                @if($jugador->email)
                                <small class="text-muted">
                                    <i class="fas fa-envelope text-muted me-1"></i>{{ $jugador->email }}
                                </small>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                <i class="fas fa-shield-alt me-1"></i>{{ $jugador->club_nombre ?? 'Sin club' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge bg-{{ $jugador->status == 'activo' ? 'success' : 'warning' }} text-white px-3 py-2 rounded-pill">
                                <i class="fas fa-{{ $jugador->status == 'activo' ? 'check' : 'clock' }} me-1"></i>
                                {{ ucfirst($jugador->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-end">
                            <div class="btn-group" role="group">
                                @if($jugador->status!="activo")
                                <a href="{{ route('jugadores.edit', $jugador->id) }}" 
                                   class="btn btn-outline-warning btn-sm"
                                   title="Editar jugador">
                                    <i class="fas fa-edit me-1"></i><span class="d-none d-md-inline">Editar</span>
                                </a>
                                @endif
                                @if(auth()->user()->rol_id=="administrador")
                                <button type="button" 
                                        class="btn btn-outline-info btn-sm"
                                        onclick="confirmAction('{{ route('jugadores.aceptar', $jugador->id) }}', '¿Estás seguro de aceptar este jugador?')"
                                        title="Aceptar jugador">
                                    <i class="fas fa-check me-1"></i><span class="d-none d-md-inline">Aceptar</span>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="confirmAction('{{ route('jugadores.destroy', $jugador->id) }}', '¿Estás seguro de rechazar este jugador?')"
                                        title="Rechazar jugador">
                                    <i class="fas fa-times me-1"></i><span class="d-none d-md-inline">Rechazar</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-users fa-4x text-muted mb-4"></i>
                                <h5 class="text-muted mb-3">No hay jugadores registrados</h5>
                                <p class="text-muted mb-4">Aún no se han registrado jugadores en el sistema.</p>
                                <a href="{{ route('jugadores.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Registrar Primer Jugador
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Formulario oculto para acciones -->
<form id="actionForm" method="POST" style="display: none;">
    @csrf
</form>

<script>
    // Funcionalidad de búsqueda en tiempo real
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        const rows = $('.jugador-row');
        
        rows.each(function() {
            const row = $(this);
            const text = row.text().toLowerCase();
            
            if (text.includes(searchTerm)) {
                row.show();
                row.addClass('highlight-row');
            } else {
                row.hide();
                row.removeClass('highlight-row');
            }
        });
        
        // Mostrar mensaje si no hay resultados
        const visibleRows = rows.filter(':visible');
        if (visibleRows.length === 0 && searchTerm !== '') {
            if ($('#no-results').length === 0) {
                $('#jugadoresTable tbody').append(`
                    <tr id="no-results">
                        <td colspan="6" class="text-center py-4">
                            <div class="py-3">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted mb-2">No se encontraron resultados</h6>
                                <p class="text-muted mb-0">Intenta con otros términos de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                `);
            }
        } else {
            $('#no-results').remove();
        }
    });

    // Limpiar búsqueda
    $('#searchInput').on('focus', function() {
        if ($(this).val() === '') {
            $('.jugador-row').removeClass('highlight-row');
        }
    });

    // Efectos hover en las filas
    $('.jugador-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Función para confirmar acciones
    function confirmAction(url, message) {
        if (confirm(message)) {
            const form = document.getElementById('actionForm');
            form.action = url;
            form.submit();
        }
    }

    // Tooltips para los botones
    $('[title]').tooltip();
    
    // Mejoras para móvil
    if (window.innerWidth <= 768) {
        // Agregar indicador de carga en búsqueda
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val();
            if (searchTerm.length > 0) {
                $('.table-responsive').addClass('searching');
            } else {
                $('.table-responsive').removeClass('searching');
            }
        });
        
        // Mejorar la experiencia de touch
        $('.btn').on('touchstart', function() {
            $(this).addClass('touch-active');
        }).on('touchend', function() {
            $(this).removeClass('touch-active');
        });
        
        // Agregar feedback háptico (si está disponible)
        if ('vibrate' in navigator) {
            $('.btn').on('click', function() {
                navigator.vibrate(10);
            });
        }
    }
</script>
@endsection
