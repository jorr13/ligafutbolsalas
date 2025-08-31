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
    .position-relative img {
        transition: all 0.3s ease;
    }
    
    .position-relative:hover img {
        transform: scale(1.05);
    }
    
    /* Estilos para los badges de estado */
    .position-absolute {
        transition: all 0.3s ease;
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
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
                                <i class="fas fa-users me-2"></i>Jugadores del Club
                            </h2>
                            <p class="text-muted mb-0">{{ $club->nombre }}</p>
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
                    <div class="input-group" style="max-width: 300px; margin-left: auto;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar jugador...">
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
                            <i class="fas fa-tshirt text-muted me-2"></i>Dorsal
                        </th>
                        <th class="border-0 py-3 px-4">
                            <i class="fas fa-tag text-muted me-2"></i>Categoría
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
                                                                                                             <img src="{{ $jugador->foto_identificacion ? asset('images/' . $jugador->foto_identificacion) : '/images/default-avatar.png' }}"  
                                         alt="Foto de {{ $jugador->nombre }}" 
                                         class="rounded-circle border-2 border-light shadow-sm" 
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
                            <div class="text-center">
                                <span class="badge bg-primary rounded-pill px-3 py-2 fw-bold" style="font-size: 0.9rem;">
                                    {{ $jugador->numero_dorsal ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                {{ $jugador->nombre_categoria ?? 'Sin categoría' }}
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
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                                        onclick="getJugador({{ $jugador->id }})"
                                        title="Ver perfil completo">
                                    <i class="fas fa-eye me-1"></i>Ver
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm" 
                                        onclick="window.open('tel:{{ $jugador->telefono }}')"
                                        title="Llamar al jugador"
                                        {{ !$jugador->telefono ? 'disabled' : '' }}>
                                    <i class="fas fa-phone me-1"></i>Llamar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-5">
                                <i class="fas fa-users fa-4x text-muted mb-4"></i>
                                <h5 class="text-muted mb-3">No hay jugadores registrados</h5>
                                <p class="text-muted mb-4">Este club aún no tiene jugadores en el sistema.</p>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Agregar Primer Jugador
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="staticBackdropLabel">
                        <i class="fas fa-user-circle me-2"></i>Perfil del Jugador
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Spinner de carga -->
                    <div class="text-center py-5" id="spinner">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="text-muted mt-3">Cargando información del jugador...</p>
                    </div>
                    
                    <!-- Contenido del jugador -->
                    <div id="jugador-content" class="d-none">
                        <div class="row g-0">
                            <!-- Columna izquierda - Foto y datos básicos -->
                            <div class="col-md-4 bg-light p-4">
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img id="jugador-foto" src="" alt="Foto del jugador" 
                                             class="rounded-circle border-4 border-white shadow" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                        <div id="status-badge" class="position-absolute bottom-0 end-0 bg-success rounded-circle border-3 border-white" 
                                             style="width: 25px; height: 25px;"></div>
                                    </div>
                                </div>
                                
                                <div class="text-center mb-3">
                                    <h4 id="jugador-nombre" class="fw-bold text-dark mb-1"></h4>
                                    <span id="jugador-categoria" class="badge bg-info text-white px-3 py-2"></span>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-phone me-2"></i>Llamar
                                    </button>
                                    <button class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-envelope me-2"></i>Enviar Email
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Columna derecha - Información detallada -->
                            <div class="col-md-8 p-4">
                                <div class="row g-3">
                                    <!-- Información Personal -->
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-id-card me-2"></i>Información Personal
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-id-badge text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Cédula</small>
                                                        <strong id="jugador-cedula"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-phone text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Teléfono</small>
                                                        <strong id="jugador-telefono"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-envelope text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Email</small>
                                                        <strong id="jugador-email"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-tshirt text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Número de Camiseta</small>
                                                        <strong id="jugador-dorsal"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Información del Representante -->
                                    <div class="col-12">
                                        <h6 class="text-primary fw-bold mb-3">
                                            <i class="fas fa-user-friends me-2"></i>Información del Representante
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-user text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Nombre</small>
                                                        <strong id="jugador-representante-nombre"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-id-badge text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Cédula</small>
                                                        <strong id="jugador-representante-cedula"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-phone text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Teléfono</small>
                                                        <strong id="jugador-representante-telefono"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Estado del Jugador -->
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3 bg-light rounded">
                                            <i class="fas fa-check-circle text-muted me-3"></i>
                                            <div>
                                                <small class="text-muted d-block">Estado</small>
                                                <span id="jugador-status" class="badge fs-6"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editar Jugador
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getJugador(id){
        // Mostrar spinner y ocultar contenido
        $('#spinner').show();
        $('#jugador-content').addClass('d-none');
        
        $.ajax({
            url: "{{ route('jugadores.infoJugador') }}",
            type: "POST",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            data: { id: id },
            success: function(response) {
                // Ocultar spinner y mostrar contenido
                $('#spinner').hide();
                $('#jugador-content').removeClass('d-none');
                
                // Actualizar título del modal
                $('#staticBackdropLabel').html('<i class="fas fa-user-circle me-2"></i>Perfil del Jugador');
                
                // Llenar datos del jugador
                $('#jugador-foto').attr('src', response.data.foto_identificacion ? '/storage/' + response.data.foto_identificacion : '/images/default-avatar.png');
                $('#jugador-nombre').text(response.data.nombre || 'Sin nombre');
                $('#jugador-categoria').text(response.data.nombre_categoria || 'Sin categoría');
                $('#jugador-cedula').text(response.data.cedula || 'No especificada');
                $('#jugador-telefono').text(response.data.telefono || 'No especificado');
                $('#jugador-email').text(response.data.email || 'No especificado');
                $('#jugador-dorsal').text(response.data.numero_dorsal || 'No especificado');
                
                // Información del representante
                $('#jugador-representante-nombre').text(response.data.nombre_representante || 'No especificado');
                $('#jugador-representante-cedula').text(response.data.cedula_representante || 'No especificada');
                $('#jugador-representante-telefono').text(response.data.telefono_representante || 'No especificado');
                
                // Estado del jugador
                const status = response.data.status || 'pendiente';
                const statusClass = status === 'activo' ? 'bg-success' : 'bg-warning';
                const statusText = status === 'activo' ? 'Activo' : 'Pendiente';
                $('#jugador-status').removeClass('bg-success bg-warning').addClass(statusClass).text(statusText);
                
                // Actualizar badge de estado en la foto
                const statusBadgeClass = status === 'activo' ? 'bg-success' : 'bg-warning';
                $('#status-badge').removeClass('bg-success bg-warning').addClass(statusBadgeClass);
                
                // Configurar botones de acción
                if (response.data.telefono) {
                    $('.btn-outline-primary').attr('onclick', `window.open('tel:${response.data.telefono}')`);
                }
                if (response.data.email) {
                    $('.btn-outline-success').attr('onclick', `window.open('mailto:${response.data.email}')`);
                }
            },
            error: function (xhr, status, error) {
                // Ocultar spinner y mostrar mensaje de error
                $('#spinner').hide();
                $('#jugador-content').removeClass('d-none');
                $('#jugador-content').html(`
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <h5 class="text-muted">Error al cargar la información</h5>
                        <p class="text-muted">No se pudo obtener la información del jugador. Inténtalo de nuevo.</p>
                        <button class="btn btn-primary" onclick="getJugador(${id})">
                            <i class="fas fa-redo me-2"></i>Reintentar
                        </button>
                    </div>
                `);
                console.error('Error al cargar jugador:', error);
            }
        });
    }
    
    // Limpiar modal cuando se cierre
    $('#staticBackdrop').on('hidden.bs.modal', function () {
        $('#spinner').show();
        $('#jugador-content').addClass('d-none');
    });

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

    // Tooltips para los botones
    $('[title]').tooltip();
</script>
@endsection
