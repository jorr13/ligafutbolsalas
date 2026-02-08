@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-1 text-primary fw-bold">
                        <i class="fas fa-search me-2"></i>Buscar Jugador
                    </h2>
                    <p class="text-muted mb-0">Busca jugadores activos por cédula o nombre</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de búsqueda -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-filter me-2 text-primary"></i>Filtros de búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('jugadores.buscar') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="filtro" class="form-label text-muted small">Buscar por</label>
                    <select name="filtro" id="filtro" class="form-select">
                        <option value="nombre" {{ ($filtro ?? 'nombre') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                        <option value="cedula" {{ ($filtro ?? '') == 'cedula' ? 'selected' : '' }}>Cédula</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="search" class="form-label text-muted small">Término de búsqueda</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               placeholder="{{ ($filtro ?? 'nombre') == 'cedula' ? 'Ej: V-12345678' : 'Ej: Juan Pérez' }}" 
                               value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de resultados -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list me-2 text-primary"></i>Resultados
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 py-3 px-4"><i class="fas fa-user-circle text-muted me-2"></i>Jugador</th>
                        <th class="border-0 py-3 px-4"><i class="fas fa-id-badge text-muted me-2"></i>Cédula</th>
                        <th class="border-0 py-3 px-4"><i class="fas fa-shield-alt text-muted me-2"></i>Club</th>
                        <th class="border-0 py-3 px-4"><i class="fas fa-tag text-muted me-2"></i>Categoría</th>
                        <th class="border-0 py-3 px-4 text-end"><i class="fas fa-cogs text-muted me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jugadores as $jugador)
                    <tr class="jugador-row">
                        <td class="py-3 px-4">
                            <div class="d-flex align-items-center">
                                @php
                                    $fotoCarnetUrl = $jugador->foto_carnet 
                                        ? (str_starts_with($jugador->foto_carnet, 'jugadores/') 
                                            ? asset('storage/' . $jugador->foto_carnet) 
                                            : asset('images/' . $jugador->foto_carnet))
                                        : asset('/images/default-avatar.png');
                                @endphp
                                <img src="{{ $fotoCarnetUrl }}"  
                                     alt="Foto de {{ $jugador->nombre }}" 
                                     class="rounded-circle border-2 border-light shadow-sm me-3" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="fw-bold text-dark">{{ $jugador->nombre }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4"><span class="fw-medium">{{ $jugador->cedula }}</span></td>
                        <td class="py-3 px-4">
                            <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                {{ $jugador->club_nombre ?? 'Sin club' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge bg-secondary text-white px-3 py-2 rounded-pill">
                                {{ $jugador->categoria_nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-end">
                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                    data-bs-toggle="modal" data-bs-target="#modalPerfilJugador" 
                                    onclick="getJugador({{ $jugador->id }})"
                                    title="Ver perfil completo">
                                <i class="fas fa-eye me-1"></i>Ver
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            @if(empty($search))
                                <div class="py-5">
                                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                                    <h5 class="text-muted mb-3">Ingrese un término de búsqueda</h5>
                                    <p class="text-muted mb-0">Escriba cédula o nombre y presione Buscar para ver resultados.</p>
                                </div>
                            @else
                                <div class="py-5">
                                    <i class="fas fa-user-slash fa-4x text-muted mb-4"></i>
                                    <h5 class="text-muted mb-3">No se encontraron jugadores</h5>
                                    <p class="text-muted mb-0">No hay jugadores activos que coincidan con "{{ $search }}".</p>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($jugadores, 'hasPages') && $jugadores->hasPages())
        @php app()->setLocale('es'); @endphp
        <div class="pagination-container border-top">
            <div class="pagination-wrapper p-3">
                <div class="pagination-info">
                    Mostrando {{ $jugadores->firstItem() }} a {{ $jugadores->lastItem() }} de {{ $jugadores->total() }} jugadores
                </div>
                <div class="pagination-box">
                    {{ $jugadores->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal perfil del jugador (igual que en jugadores index) -->
<div class="modal fade" id="modalPerfilJugador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalPerfilLabel">
                    <i class="fas fa-user-circle me-2"></i>Perfil del Jugador
                </h5>
                <button type="button" class="btn-close btn-close-white cerrar-modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="text-center py-5" id="spinner">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="text-muted mt-3">Cargando información del jugador...</p>
                </div>
                <div id="jugador-content" class="d-none">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light p-4">
                            <div class="text-center mb-4">
                                <img id="jugador-foto" src="" alt="Foto del jugador" 
                                     class="rounded-circle border-4 border-white shadow" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="text-center mb-3">
                                <h4 id="jugador-nombre" class="fw-bold text-dark mb-1"></h4>
                                <span id="jugador-categoria" class="badge bg-info text-white px-3 py-2"></span>
                                <span id="jugador-nivel" class="badge bg-info text-white px-3 py-2"></span>
                            </div>
                        </div>
                        <div class="col-md-8 p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h6 class="text-primary fw-bold mb-3"><i class="fas fa-id-card me-2"></i>Información Personal</h6>
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
                                <div class="col-12" id="jugador-representante-section">
                                    <h6 class="text-primary fw-bold mb-3"><i class="fas fa-user-friends me-2"></i>Información del Representante</h6>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.cerrar-modal').on('click', function() {
        $('#modalPerfilJugador').modal('hide');
    });
});

function getJugador(id) {
    $('#spinner').show();
    $('#jugador-content').addClass('d-none');
    
    $.ajax({
        url: "{{ route('jugadores.infoJugador') }}",
        type: "POST",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        data: { id: id },
        success: function(response) {
            $('#spinner').hide();
            $('#jugador-content').removeClass('d-none');
            
            const fotoUrl = response.data.foto_carnet 
                ? ('{{ asset('storage/') }}/' + response.data.foto_carnet) 
                : '{{ asset('/images/default-avatar.png') }}';
            $('#jugador-foto').attr('src', fotoUrl);
            $('#jugador-nombre').text(response.data.nombre || 'Sin nombre');
            $('#jugador-categoria').text(response.data.categoria_nombre || 'Sin categoría');
            $('#jugador-cedula').text(response.data.cedula || 'No especificada');
            $('#jugador-dorsal').text(response.data.numero_dorsal || 'No especificado');
            $('#jugador-nivel').text(response.data.nivel || 'No especificado');
            
            // Teléfono y email: solo visibles para admin (restaurar estructura en cada carga)
            const telVal = response.data.telefono || 'No especificado';
            const emailVal = response.data.email || 'No especificado';
            const restringido = '<span class="text-muted fst-italic"><i class="fas fa-lock text-muted me-1"></i>Información restringida</span>';
            if (response.mostrar_contacto) {
                $('#jugador-telefono-container').html('<div class="d-flex align-items-center p-3 bg-light rounded"><i class="fas fa-phone text-muted me-3"></i><div><small class="text-muted d-block">Teléfono</small><strong id="jugador-telefono">' + telVal + '</strong></div></div>');
                $('#jugador-email-container').html('<div class="d-flex align-items-center p-3 bg-light rounded"><i class="fas fa-envelope text-muted me-3"></i><div><small class="text-muted d-block">Email</small><strong id="jugador-email">' + emailVal + '</strong></div></div>');
            } else {
                $('#jugador-telefono-container').html('<div class="d-flex align-items-center p-3 bg-light rounded"><i class="fas fa-phone text-muted me-3"></i><div><small class="text-muted d-block">Teléfono</small>' + restringido + '</div></div>');
                $('#jugador-email-container').html('<div class="d-flex align-items-center p-3 bg-light rounded"><i class="fas fa-envelope text-muted me-3"></i><div><small class="text-muted d-block">Email</small>' + restringido + '</div></div>');
            }
            
            // Información del representante: solo visible para admin
            if (response.mostrar_contacto) {
                $('#jugador-representante-section').show();
                $('#jugador-representante-nombre').text(response.data.nombre_representante || 'No especificado');
                $('#jugador-representante-cedula').text(response.data.cedula_representante || 'No especificada');
                $('#jugador-representante-telefono').text(response.data.telefono_representante || 'No especificado');
            } else {
                $('#jugador-representante-section').hide();
            }
            
            const status = response.data.status || 'activo';
            const statusClass = status === 'activo' ? 'bg-success' : 'bg-warning';
            const statusText = status === 'activo' ? 'Activo' : 'Pendiente';
            $('#jugador-status').removeClass('bg-success bg-warning').addClass(statusClass).text(statusText);
        },
        error: function(xhr, status, error) {
            $('#spinner').hide();
            $('#jugador-content').removeClass('d-none').html(`
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                    <h5 class="text-muted">Error al cargar la información</h5>
                    <p class="text-muted">No se pudo obtener la información del jugador.</p>
                    <button class="btn btn-primary mt-2" onclick="getJugador(${id})">
                        <i class="fas fa-redo me-2"></i>Reintentar
                    </button>
                </div>
            `);
        }
    });
}
</script>
@endsection
