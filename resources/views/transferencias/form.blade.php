@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exchange-alt me-3 fs-4"></i>
                    <div>
                        <h4 class="mb-0">Transferir Jugador</h4>
                        <small>Administración de transferencias entre clubes</small>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- Información del jugador -->
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-user me-2"></i>Información del Jugador
                            </h6>
                            <p class="mb-1"><strong>Nombre:</strong> {{ $jugador->nombre }}</p>
                            <p class="mb-1"><strong>Cédula:</strong> {{ $jugador->cedula }}</p>
                            <p class="mb-1"><strong>Club Actual:</strong> {{ $jugador->club->nombre ?? 'Sin club' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-info-circle me-2"></i>Detalles Adicionales
                            </h6>
                            <p class="mb-1"><strong>Categoría:</strong> {{ $jugador->categoria->nombre ?? 'Sin categoría' }}</p>
                            <p class="mb-1"><strong>Estado:</strong> 
                                <span class="badge bg-{{ $jugador->status == 'activo' ? 'success' : ($jugador->status == 'pendiente' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($jugador->status) }}
                                </span>
                            </p>
                            <p class="mb-0"><strong>Dorsal:</strong> {{ $jugador->numero_dorsal ?? 'Sin asignar' }}</p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <h6 class="alert-heading">
                            <i class="fas fa-exclamation-triangle me-2"></i>Error en el formulario
                        </h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario de transferencia -->
                <form action="{{ route('admin.jugadores.transferir.store', $jugador->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="club_nuevo_id" class="form-label fw-bold">
                                <i class="fas fa-building me-2 text-primary"></i>Club de Destino
                            </label>
                            <select class="form-select form-select-lg @error('club_nuevo_id') is-invalid @enderror" 
                                    id="club_nuevo_id" name="club_nuevo_id" required>
                                <option value="">Seleccione un club...</option>
                                @foreach($clubes as $club)
                                    @if($club->id != $jugador->club_id)
                                        <option value="{{ $club->id }}" 
                                                {{ old('club_nuevo_id') == $club->id ? 'selected' : '' }}>
                                            {{ $club->nombre }} - {{ $club->localidad }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('club_nuevo_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                El jugador será transferido al club seleccionado
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="descripcion" class="form-label fw-bold">
                                <i class="fas fa-comment me-2 text-primary"></i>Descripción (Opcional)
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3" 
                                      placeholder="Motivo de la transferencia...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Esta información quedará registrada en el historial
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('entrenador.clubes.jugadores', $jugador->club_id) }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            {{ __('Cancelar') }}
                        </a>
                        
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-exchange-alt me-2"></i>Confirmar Transferencia
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información Importante
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success mb-2">
                            <i class="fas fa-check-circle me-2"></i>Proceso de Transferencia
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-arrow-right text-primary me-2"></i>El jugador cambiará de club inmediatamente</li>
                            <li><i class="fas fa-arrow-right text-primary me-2"></i>Su estado se mantendrá como "Activo"</li>
                            <li><i class="fas fa-arrow-right text-primary me-2"></i>Se registrará en el historial de transferencias</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>Consideraciones
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-arrow-right text-warning me-2"></i>Esta acción no se puede deshacer</li>
                            <li><i class="fas fa-arrow-right text-warning me-2"></i>El jugador mantendrá su estado activo</li>
                            <li><i class="fas fa-arrow-right text-warning me-2"></i>Se registrará en el historial completo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validación del formulario
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Confirmación antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    const clubSelect = document.getElementById('club_nuevo_id');
    const selectedClub = clubSelect.options[clubSelect.selectedIndex].text;
    
    if (!confirm(`¿Está seguro de transferir a ${selectedClub}? Esta acción no se puede deshacer.`)) {
        e.preventDefault();
    }
});
</script>
@endsection
