@extends('layouts.app')

@section('styles')
<style>
    /* Estilos personalizados para la tabla */
    .table th {
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
    }
    
    .arbitro-row {
        transition: all 0.2s ease-in-out;
        border-left: 3px solid transparent;
    }
    
    .arbitro-row:hover {
        border-left-color: #8F0000;
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
        box-shadow: 0 0 0 0.2rem rgba(143, 0, 0, 0.25);
        border-color: #8F0000;
    }
    
    /* Estilos para las imágenes de perfil */
    .arbitro-avatar {
        transition: all 0.3s ease;
    }
    
    .arbitro-avatar:hover {
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
        .table th:nth-child(3),
        .table td:nth-child(3),
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
        
        /* Información del entrenador más compacta */
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
    
    /* Estilos para el paginador */
    .pagination {
        margin: 0;
        justify-content: center;
    }
    
    .pagination .page-link {
        color: #8F0000;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .pagination .page-link:hover {
        color: #6B0000;
        background-color: #e9ecef;
        border-color: #adb5bd;
        transform: translateY(-1px);
    }
    
    .pagination .page-item.active .page-link {
        background-color: #8F0000;
        border-color: #8F0000;
        color: white;
        box-shadow: 0 2px 4px rgba(143, 0, 0, 0.3);
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
        cursor: not-allowed;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    /* Responsive para el paginador */
    @media (max-width: 768px) {
        .pagination {
            flex-wrap: wrap;
            gap: 0.25rem;
        }
        
        .pagination .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
            margin: 0 1px;
        }
        
        .card-footer .d-flex {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .card-footer .text-muted {
            order: 2;
        }
        
        .pagination-wrapper {
            order: 1;
        }
    }
    
    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.25rem 0.375rem;
            font-size: 0.8rem;
            min-width: 32px;
            text-align: center;
        }
        
        .pagination .page-item:not(.active):not(.disabled) .page-link {
            display: none;
        }
        
        .pagination .page-item:first-child,
        .pagination .page-item:last-child,
        .pagination .page-item.active,
        .pagination .page-item:has(.page-link[aria-label*="Previous"]),
        .pagination .page-item:has(.page-link[aria-label*="Next"]) {
            display: block;
        }
        
        .pagination .page-item:has(.page-link[aria-label*="Previous"]) .page-link::before {
            content: "‹";
        }
        
        .pagination .page-item:has(.page-link[aria-label*="Next"]) .page-link::before {
            content: "›";
        }
        
        .pagination .page-item:has(.page-link[aria-label*="Previous"]) .page-link,
        .pagination .page-item:has(.page-link[aria-label*="Next"]) .page-link {
            font-size: 0;
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
                                <i class="fas fa-whistle me-2"></i>Gestión de Árbitros
                            </h2>
                            <p class="text-muted mb-0">Administra todos los árbitros de la liga</p>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end">
                                        <h3 class="h5 mb-1 text-success">{{ $arbitros->where('estatus', 'activo')->count() }}</h3>
                                        <small class="text-muted">Activos</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end">
                                        <h3 class="h5 mb-1 text-secondary">{{ $arbitros->where('estatus', 'inactivo')->count() }}</h3>
                                        <small class="text-muted">Inactivos</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h3 class="h5 mb-1 text-info">{{ $arbitros->total() }}</h3>
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
                        <i class="fas fa-list me-2 text-primary"></i>Lista de Árbitros
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar árbitro...">
                        </div>
                        @if(auth()->user()->rol_id=="administrador")
                        <a href="{{ route('arbitros.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nuevo Árbitro
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="arbitrosTable">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-whistle text-muted me-2"></i>Árbitro
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-id-badge text-muted me-2"></i>Cédula
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-phone text-muted me-2"></i>Contacto
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
                    @forelse ($arbitros as $arbitro)
                    <tr class="arbitro-row">
                        <td class="py-3 px-4">
                            <div class="d-flex align-items-center">
                                <div class="position-relative me-3">
                                    <div class="position-absolute bottom-0 end-0 bg-{{ $arbitro->estatus == 'activo' ? 'success' : 'secondary' }} rounded-circle border-2 border-white" 
                                         style="width: 12px; height: 12px;"></div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $arbitro->nombre }}</h6>
                                    <small class="text-muted">{{ $arbitro->email ?? 'Sin email' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="fw-medium text-dark">{{ $arbitro->cedula }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-dark">
                                    <i class="fas fa-phone text-muted me-1"></i>{{ $arbitro->telefono ?? 'No especificado' }}
                                </span>
                                @if($arbitro->email)
                                <small class="text-muted">
                                    <i class="fas fa-envelope text-muted me-1"></i>{{ $arbitro->email }}
                                </small>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge bg-{{ $arbitro->estatus == 'activo' ? 'success' : 'secondary' }} text-white px-3 py-2 rounded-pill">
                                <i class="fas fa-{{ $arbitro->estatus == 'activo' ? 'check' : 'pause' }} me-1"></i>
                                {{ ucfirst($arbitro->estatus) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-end">
                            <div class="btn-group" role="group">
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('arbitros.edit', $arbitro) }}" 
                                   class="btn btn-outline-warning btn-sm"
                                   title="Editar árbitro">
                                    <i class="fas fa-edit me-1"></i><span class="d-none d-md-inline">Editar</span>
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="confirmDelete({{ $arbitro->id }}, '{{ $arbitro->nombre }}')"
                                        title="Eliminar árbitro">
                                    <i class="fas fa-trash me-1"></i><span class="d-none d-md-inline">Eliminar</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-whistle fa-4x text-muted mb-4"></i>
                                <h5 class="text-muted mb-3">No hay árbitros registrados</h5>
                                <p class="text-muted mb-4">Aún no se han registrado árbitros en el sistema.</p>
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('arbitros.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Registrar Primer Árbitro
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginador -->
        @if($arbitros->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    <small>
                        Mostrando {{ $arbitros->firstItem() }} a {{ $arbitros->lastItem() }} de {{ $arbitros->total() }} árbitros
                    </small>
                </div>
                <div class="pagination-wrapper">
                    {{ $arbitros->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Funcionalidad de búsqueda en tiempo real
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        const rows = $('.arbitro-row');
        
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
                $('#arbitrosTable tbody').append(`
                    <tr id="no-results">
                        <td colspan="7" class="text-center py-4">
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
            $('.arbitro-row').removeClass('highlight-row');
        }
    });

    // Efectos hover en las filas
    $('.arbitro-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Función para confirmar eliminación
    function confirmDelete(id, nombre) {
        if (confirm(`¿Estás seguro de eliminar el árbitro "${nombre}"? Esta acción no se puede deshacer.`)) {
            const form = document.getElementById('deleteForm');
            form.action = `/arbitros/${id}`;
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
