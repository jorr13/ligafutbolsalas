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
    
    /* Estilos minimalistas para el paginador */
    .pagination-container {
        background: #ffffff;
        border-top: 1px solid #e9ecef;
        padding: 1.5rem 1rem;
        margin-top: 0;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .pagination-info {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 400;
    }
    
    .pagination-box {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    
    /* Ocultar el texto "Showing X to Y of Z results" que Laravel muestra por defecto */
    .pagination-box > div:first-child {
        display: none !important;
    }
    
    .pagination {
        margin: 0;
        display: flex;
        list-style: none;
        padding: 0;
        gap: 0.5rem;
        align-items: center;
    }
    
    .pagination .page-item {
        margin: 0;
    }
    
    .pagination .page-link {
        color: #333333;
        background: transparent;
        border: none;
        padding: 0.5rem 0.75rem;
        margin: 0;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        line-height: 1.5;
        font-weight: 400;
    }
    
    .pagination .page-link:hover:not(.disabled):not(.active-link) {
        color: #007bff;
        text-decoration: underline;
    }
    
    /* Botón Siguiente con estilo azul */
    .pagination .page-item:last-child .page-link:not(.disabled) {
        background-color: #007bff;
        color: #ffffff !important;
        font-weight: 400;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        text-decoration: none;
    }
    
    .pagination .page-item:last-child .page-link:not(.disabled):hover {
        background-color: #0056b3;
        text-decoration: none;
        color: #ffffff !important;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: #ffffff;
        font-weight: 500;
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
    }
    
    .pagination .page-item.active .page-link:hover {
        text-decoration: none;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #999999;
        cursor: not-allowed;
        pointer-events: none;
        opacity: 0.6;
    }
    
    .pagination .page-item.disabled .page-link:hover {
        text-decoration: none;
    }
    
    /* Ocultar números de página que no sean necesarios, solo mostrar Anterior/Siguiente y página actual */
    .pagination .page-item:not(.active):not(.disabled):not(:first-child):not(:last-child) {
        display: none;
    }
    
    /* Ocultar cualquier texto adicional que Laravel pueda mostrar */
    .pagination-box > div:not(.pagination):not(nav) {
        display: none !important;
    }
    
    .pagination-box > p,
    .pagination-box > small {
        display: none !important;
    }
    
    /* Responsive para el paginador */
    @media (max-width: 768px) {
        .pagination-container {
            padding: 1.25rem 0.75rem;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
        
        .pagination-info {
            order: 2;
            text-align: center;
        }
        
        .pagination-box {
            order: 1;
            width: 100%;
            justify-content: center;
        }
        
        .pagination {
            width: 100%;
            justify-content: center;
        }
        
        .pagination .page-link {
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 576px) {
        .pagination-container {
            padding: 1rem 0.5rem;
        }
        
        .pagination-info {
            font-size: 0.85rem;
        }
        
        .pagination .page-link {
            padding: 0.5rem 0.7rem;
            font-size: 0.85rem;
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
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group" style="max-width: 280px;">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar árbitro...">
                            </div>
                            <button type="button" class="btn btn-primary" id="btnBuscar">
                                <i class="fas fa-search me-1"></i>Buscar
                            </button>
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
        
        <!-- Paginador minimalista -->
        @if($arbitros->hasPages())
        @php
            app()->setLocale('es');
        @endphp
        <div class="pagination-container">
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Mostrando {{ $arbitros->firstItem() }} a {{ $arbitros->lastItem() }} de {{ $arbitros->total() }} árbitros
                </div>
                <div class="pagination-box">
                    {{ $arbitros->appends(request()->query())->links('pagination::bootstrap-4') }}
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
    // Función para ejecutar búsqueda
    function ejecutarBusqueda() {
        const searchTerm = $('#searchInput').val().toLowerCase();
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
    }

    // Búsqueda al hacer clic en botón
    $('#btnBuscar').on('click', ejecutarBusqueda);
    
    // Búsqueda al presionar Enter
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            ejecutarBusqueda();
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
