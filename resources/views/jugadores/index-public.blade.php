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
        
        .row.g-2 {
            flex-direction: column;
        }
        
        .col-md-5, .col-md-2 {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .col-md-2 {
            margin-bottom: 0;
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

    @php
        // Obtener información del usuario autenticado una sola vez
        $rolUsuario = auth()->user()->rol_id ?? null;
        $entrenador = null;
        $clubIdEntrenador = null;
        
        if ($rolUsuario == 'entrenador') {
            $entrenador = \App\Models\Entrenadores::where('user_id', auth()->user()->id)->first();
            $clubIdEntrenador = $entrenador->club_id ?? null;
        }
    @endphp

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
                    <div class="row g-2">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar jugador...">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" id="categoriaFilter">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->nombre }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="clearFilters()" title="Limpiar filtros">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
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
                                    @php
                                        $fotoUrl = $jugador->foto_identificacion 
                                            ? (str_starts_with($jugador->foto_identificacion, 'jugadores/') 
                                                ? asset('storage/' . $jugador->foto_identificacion) 
                                                : asset('images/' . $jugador->foto_identificacion))
                                            : asset('/images/default-avatar.png');
                                    @endphp
                                    <img src="{{ $fotoUrl }}"  
                                         alt="Foto de {{ $jugador->nombre }}" 
                                         class="rounded-circle border-2 border-light shadow-sm" 
                                         style="width: 45px; height: 45px; object-fit: cover;"
                                         onerror="this.src='/images/default-avatar.png'">
                          
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $jugador->nombre }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="fw-medium text-dark">{{ $jugador->cedula }}</span>
                        </td>
                        <td class="py-3 px-4">
                            @php
                                $mostrarContacto = false;
                                
                                if ($rolUsuario == 'administrador') {
                                    $mostrarContacto = true;
                                } elseif ($rolUsuario == 'entrenador' && $clubIdEntrenador && $jugador->club_id == $clubIdEntrenador) {
                                    $mostrarContacto = true;
                                }
                            @endphp
                            
                            @if($mostrarContacto)
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
                            @else
                                <div class="d-flex flex-column">
                                    <span class="text-muted fst-italic">
                                        <i class="fas fa-lock text-muted me-1"></i>{{ __('Información restringida') }}
                                    </span>
                                </div>
                            @endif
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
                                {{ $jugador->categoria_nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge bg-{{ $jugador->status == 'activo' ? 'success' : 'warning' }} text-white px-3 py-2 rounded-pill">
                                <i class="fas fa-{{ $jugador->status == 'activo' ? 'check' : 'clock' }} me-1"></i>
                                {{ ucfirst($jugador->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-end">
                            <div class="btn-group" role="group" style='    flex-wrap: wrap;'>
                                @if(auth()->user()->rol_id=="administrador")
                                <a href="{{ route('admin.jugadores.transferir', $jugador->id) }}" 
                                   class="btn btn-outline-primary btn-sm"
                                   title="Transferir jugador">
                                    <i class="fas fa-exchange-alt me-1"></i><span class="d-none d-md-inline">Transferir</span>
                                </a>
                                <a href="{{ route('admin.jugadores.edit', $jugador->id) }}" 
                                   class="btn btn-outline-primary btn-sm"
                                   title="Editar jugador">
                                    <i class="fas fa-edit me-1"></i><span class="d-none d-md-inline">Editar</span>
                                </a>
                                <a href="{{ route('jugadores.carnet.preview', $jugador->id) }}" 
                                   class="btn btn-outline-success btn-sm"
                                   title="Ver carnet del jugador">
                                    <i class="fas fa-id-card me-1"></i><span class="d-none d-md-inline">Carnet</span>
                                </a>
                                <a href="{{ route('admin.jugadores.historial', $jugador->id) }}" 
                                   class="btn btn-outline-secondary btn-sm"
                                   title="Ver historial">
                                    <i class="fas fa-history me-1"></i><span class="d-none d-md-inline">Historial</span>
                                </a>
                                <button type="button" 
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="confirmAction('{{ route('jugadores.destroy', $jugador->id) }}', '¿Estás seguro de Eliminar este jugador?')"
                                    title="Eliminar">
                                    <i class="fas fa-times me-1"></i><span class="d-none d-md-inline">Eliminar</span>
                                </button>
                                @endif
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                                        onclick="getJugador({{ $jugador->id }})"
                                        title="Ver perfil completo">
                                    <i class="fas fa-eye me-1"></i>Ver
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


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="staticBackdropLabel">
                        <i class="fas fa-user-circle me-2"></i>Perfil del Jugador
                    </h5>
                    <button type="button" class="btn-close btn-close-white cerrar-modal"  aria-label="Close"></button>
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
                                        
                                    </div>
                                </div>
                                
                                <div class="text-center mb-3">
                                    <h4 id="jugador-nombre" class="fw-bold text-dark mb-1"></h4>
                                    <span id="jugador-categoria" class="badge bg-info text-white px-3 py-2"></span>
                                    <span id="jugador-nivel" class="badge bg-info text-white px-3 py-2"></span>
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
                                            <div class="col-sm-6" id="jugador-telefono-container">
                                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                                    <i class="fas fa-phone text-muted me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Teléfono</small>
                                                        <strong id="jugador-telefono"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" id="jugador-email-container">
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
                                    @if(auth()->user()->rol_id=="administrador")
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
            @endif                                    
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
                    <button type="button" class="btn btn-secondary cerrar-modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Formulario oculto para acciones -->
<form id="actionForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
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
                
                // Construir URL de la foto usando los datos de la respuesta
                let fotoUrl = '{{ asset("/images/default-avatar.png") }}';
                if (response.data.foto_identificacion) {
                    if (response.data.foto_identificacion.startsWith('jugadores/')) {
                        fotoUrl = '{{ asset("storage/") }}/' + response.data.foto_identificacion;
                    } else {
                        fotoUrl = '{{ asset("images/") }}/' + response.data.foto_identificacion;
                    }
                }
                
                // Llenar datos del jugador
                $('#jugador-foto').attr('src', fotoUrl).on('error', function() {
                    $(this).attr('src', '{{ asset("/images/default-avatar.png") }}');
                });
                $('#jugador-nombre').text(response.data.nombre || 'Sin nombre');
                $('#jugador-categoria').text(response.data.categoria_nombre || 'Sin categoría');
                $('#jugador-cedula').text(response.data.cedula || 'No especificada');
                
                // Aplicar lógica de permisos para teléfono y email
                if (response.mostrar_contacto && response.data.telefono) {
                    $('#jugador-telefono').text(response.data.telefono);
                    $('#jugador-telefono-container').show();
                } else {
                    $('#jugador-telefono-container').html(`
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="fas fa-phone text-muted me-3"></i>
                            <div>
                                <small class="text-muted d-block">Teléfono</small>
                                <span class="text-muted fst-italic">
                                    <i class="fas fa-lock text-muted me-1"></i>{{ __('Información restringida') }}
                                </span>
                            </div>
                        </div>
                    `);
                }
                
                if (response.mostrar_contacto && response.data.email) {
                    $('#jugador-email').text(response.data.email);
                    $('#jugador-email-container').show();
                } else {
                    $('#jugador-email-container').html(`
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="fas fa-envelope text-muted me-3"></i>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span class="text-muted fst-italic">
                                    <i class="fas fa-lock text-muted me-1"></i>{{ __('Información restringida') }}
                                </span>
                            </div>
                        </div>
                    `);
                }
                
                $('#jugador-dorsal').text(response.data.numero_dorsal || 'No especificado');
                $('#jugador-nivel').text(response.data.nivel || 'No especificado');
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
                
                                 // Configurar botones de acción solo si tiene permisos
                 if (response.mostrar_contacto && response.data.telefono) {
                     $('.btn-outline-primary').off('click').on('click', function() {
                         window.open('tel:' + response.data.telefono);
                     });
                 }
                 if (response.mostrar_contacto && response.data.email) {
                     $('.btn-outline-success').off('click').on('click', function() {
                         window.open('mailto:' + response.data.email);
                     });
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
         $('#jugador-content').removeClass('d-none').addClass('d-none');
         
         // Limpiar event listeners de los botones
         $('.btn-outline-primary').off('click');
         $('.btn-outline-success').off('click');
         
         // Limpiar contenido del modal
         $('#jugador-foto').attr('src', '');
         $('#jugador-nombre').text('');
         $('#jugador-categoria').text('');
         $('#jugador-cedula').text('');
         $('#jugador-telefono-container').html(`
             <div class="d-flex align-items-center p-3 bg-light rounded">
                 <i class="fas fa-phone text-muted me-3"></i>
                 <div>
                     <small class="text-muted d-block">Teléfono</small>
                     <strong id="jugador-telefono"></strong>
                 </div>
             </div>
         `);
         $('#jugador-email-container').html(`
             <div class="d-flex align-items-center p-3 bg-light rounded">
                 <i class="fas fa-envelope text-muted me-3"></i>
                 <div>
                     <small class="text-muted d-block">Email</small>
                     <strong id="jugador-email"></strong>
                 </div>
             </div>
         `);
         $('#jugador-dorsal').text('');
         $('#jugador-representante-nombre').text('');
         $('#jugador-representante-cedula').text('');
         $('#jugador-representante-telefono').text('');
         $('#jugador-status').removeClass('bg-success bg-warning').text('');
     });

    // Funcionalidad de búsqueda en tiempo real
    function filterJugadores() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const rows = $('.jugador-row');
        
        if (searchTerm !== '') {
            $('.jugador-row').addClass('opacity-50');
        }
        
        setTimeout(() => {
            rows.each(function() {
                const row = $(this);
                const nombre = row.find('h6').text().toLowerCase();
                
                if (nombre.includes(searchTerm)) {
                    row.show();
                    row.addClass('highlight-row');
                    row.removeClass('opacity-50');
                } else {
                    row.hide();
                    row.removeClass('highlight-row');
                }
            });
            
            // Mostrar mensaje si no hay resultados
            const visibleRows = rows.filter(':visible');
            if (visibleRows.length === 0 && searchTerm !== '') {
                if ($('#no-results').length === 0) {
                    $('#jugadores-table tbody').append(`
                        <tr id="no-results">
                            <td colspan="7" class="text-center py-4">
                                <div class="py-3">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted mb-2">No se encontraron resultados</h6>
                                    <p class="text-muted mb-0">Intenta con otros términos de búsqueda</p>
                                    <button class="btn btn-outline-primary btn-sm mt-2" onclick="clearFilters()">
                                        <i class="fas fa-times me-1"></i>Limpiar filtros
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                }
            } else {
                $('#no-results').remove();
            }
        }, 100);
    }
        // Función para confirmar acciones
        function confirmAction(url, message) {
            console.log(url, message);
            if (confirm(message)) {
                const form = document.getElementById('actionForm');
                form.action = url;
                form.submit();
            }
        }
    // Event listeners para búsqueda
    $('#searchInput').on('keyup', filterJugadores);
    
    // Limpiar filtros
    function clearFilters() {
        $('#searchInput').val('');
        filterJugadores();
    }

    // Efectos hover en las filas
    $('.jugador-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
         $('.cerrar-modal').on('click', function(e) {
         e.preventDefault();
         
         // Limpiar event listeners antes de cerrar
         $('.btn-outline-primary').off('click');
         $('.btn-outline-success').off('click');
         
         // Cerrar modal usando Bootstrap
         $('#staticBackdrop').modal('hide');
     });


    // Tooltips para los botones
    $('[title]').tooltip();
</script>
@endsection
