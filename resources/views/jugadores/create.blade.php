@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Nuevo Jugador') }}</h2>
                <p class="text-muted mb-0">{{ __('Registra un nuevo jugador en la Liga de Fútbol Sala') }}</p>
                </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-lg form-card">
                <div class="card-body p-5">
                    <form action="{{ route('jugadores.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
                        @csrf
                        
                        <!-- Información Personal -->
                        <div class="section-header mb-4">
                            <h5 class="fw-bold text-primary">
                                <i class="fas fa-user me-2"></i>
                                {{ __('Información Personal') }}
                            </h5>
                        </div>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        {{ __('Nombre Completo') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('nombre') is-invalid @enderror" 
                                               id="nombre" 
                                               name="nombre" 
                                               required 
                                               placeholder="Ej: Juan Carlos Pérez"
                                               value="{{ old('nombre') }}">
                                    </div>
                                    @error('nombre')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cedula" class="form-label fw-semibold">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        {{ __('Cédula de Identidad') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-hashtag text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('cedula') is-invalid @enderror" 
                                               id="cedula" 
                                               name="cedula" 
                                               required 
                                               placeholder="Ej: 12345678"
                                               value="{{ old('cedula') }}">
                                    </div>
                                    @error('cedula')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-2 text-primary"></i>
                                        {{ __('Teléfono') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone-alt text-muted"></i>
                                        </span>
                                        <input type="tel" 
                                               class="form-control border-start-0 @error('telefono') is-invalid @enderror" 
                                               id="telefono" 
                                               name="telefono" 
                                               placeholder="Ej: 0412-1234567"
                                               value="{{ old('telefono') }}">
                                    </div>
                                    @error('telefono')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        {{ __('Correo Electrónico') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-at text-muted"></i>
                                        </span>
                                        <input type="email" 
                                               class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               placeholder="Ej: jugador@email.com"
                                               value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion" class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                        {{ __('Dirección') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-home text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('direccion') is-invalid @enderror" 
                                               id="direccion" 
                                               name="direccion" 
                                               placeholder="Ej: Av. Principal, Caracas"
                                               value="{{ old('direccion') }}">
                                    </div>
                                    @error('direccion')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_dorsal" class="form-label fw-semibold">
                                        <i class="fas fa-tshirt me-2 text-primary"></i>
                                        {{ __('Número Dorsal') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-hashtag text-muted"></i>
                                        </span>
                                        <input type="number" 
                                               class="form-control border-start-0 @error('numero_dorsal') is-invalid @enderror" 
                                               id="numero_dorsal" 
                                               name="numero_dorsal" 
                                               placeholder="Ej: 10"
                                               value="{{ old('numero_dorsal') }}">
                                    </div>
                                    @error('numero_dorsal')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edad" class="form-label fw-semibold">
                                        <i class="fas fa-birthday-cake me-2 text-primary"></i>
                                        {{ __('Edad') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar text-muted"></i>
                                        </span>
                                        <input type="number" 
                                               class="form-control border-start-0 @error('edad') is-invalid @enderror" 
                                               id="edad" 
                                               name="edad" 
                                               placeholder="Ej: 18"
                                               value="{{ old('edad') }}">
                                    </div>
                                    @error('edad')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        {{ __('Fecha de Nacimiento') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar text-muted"></i>
                                        </span>
                                        <input type="date" 
                                               class="form-control border-start-0 @error('fecha_nacimiento') is-invalid @enderror" 
                                               id="fecha_nacimiento" 
                                               name="fecha_nacimiento" 
                                               value="{{ old('fecha_nacimiento') }}">
                                    </div>
                                    @error('fecha_nacimiento')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_sangre" class="form-label fw-semibold">
                                        <i class="fas fa-heartbeat me-2 text-primary"></i>
                                        {{ __('Tipo de Sangre') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-tint text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('tipo_sangre') is-invalid @enderror" 
                                               id="tipo_sangre" 
                                               name="tipo_sangre" 
                                               placeholder="Ej: O+"
                                               value="{{ old('tipo_sangre') }}">
                                    </div>
                                    @error('tipo_sangre')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria_id" class="form-label fw-semibold">
                                        <i class="fas fa-tags me-2 text-primary"></i>
                                        {{ __('Categoría') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-tag text-muted"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('categoria_id') is-invalid @enderror" 
                                                id="categoria_id" 
                                                name="categoria_id">
                                            <option value="" selected disabled>{{ __('Seleccione una categoría...') }}</option>
                                    @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                    {{ $categoria->nombre }}
                                                </option>
                                    @endforeach
                                </select>
                            </div>
                                    @error('categoria_id')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nivel" class="form-label fw-semibold">
                                        <i class="fas fa-star me-2 text-primary"></i>
                                        {{ __('Nivel') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-trophy text-muted"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('nivel') is-invalid @enderror" 
                                                id="nivel" 
                                                name="nivel">
                                            <option value="iniciante" {{ old('nivel', 'iniciante') == 'iniciante' ? 'selected' : '' }}>{{ __('Iniciante') }}</option>
                                            <option value="formativo" {{ old('nivel', 'formativo') == 'formativo' ? 'selected' : '' }}>{{ __('Formativo') }}</option>
                                            <option value="elite" {{ old('nivel') == 'elite' ? 'selected' : '' }}>{{ __('Élite') }}</option>
                                        </select>
                                    </div>
                                    @error('nivel')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información del Representante -->
                        <div class="section-header mb-4">
                            <h5 class="fw-bold text-primary">
                                <i class="fas fa-user-tie me-2"></i>
                                {{ __('Información del Representante') }}
                            </h5>
                        </div>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_representante" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        {{ __('Nombre del Representante') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('nombre_representante') is-invalid @enderror" 
                                               id="nombre_representante" 
                                               name="nombre_representante" 
                                               placeholder="Ej: María González"
                                               value="{{ old('nombre_representante') }}">
                                    </div>
                                    @error('nombre_representante')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cedula_representante" class="form-label fw-semibold">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        {{ __('Cédula del Representante') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-hashtag text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('cedula_representante') is-invalid @enderror" 
                                               id="cedula_representante" 
                                               name="cedula_representante" 
                                               placeholder="Ej: V-87654321"
                                               value="{{ old('cedula_representante') }}">
                                    </div>
                                    @error('cedula_representante')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono_representante" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-2 text-primary"></i>
                                        {{ __('Teléfono del Representante') }}
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone-alt text-muted"></i>
                                        </span>
                                        <input type="tel" 
                                               class="form-control border-start-0 @error('telefono_representante') is-invalid @enderror" 
                                               id="telefono_representante" 
                                               name="telefono_representante" 
                                               placeholder="Ej: 0412-7654321"
                                               value="{{ old('telefono_representante') }}">
                                    </div>
                                    @error('telefono_representante')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Documentos -->
                        <div class="section-header mb-4">
                            <h5 class="fw-bold text-primary">
                                <i class="fas fa-file-alt me-2"></i>
                                {{ __('Documentos') }}
                            </h5>
                            </div>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto_carnet" class="form-label fw-semibold">
                                        <i class="fas fa-camera me-2 text-primary"></i>
                                        {{ __('Foto Carnet') }}
                                    </label>
                                    <div class="file-upload-container">
                                        <div class="file-upload-area" id="fotoCarnetArea">
                                            <div class="file-upload-content">
                                                <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                                <h5 class="text-muted mb-2">{{ __('Arrastra la foto aquí') }}</h5>
                                                <p class="text-muted small mb-3">
                                                    <span class="d-none d-md-inline">{{ __('o haz clic para seleccionar') }}</span>
                                                    <span class="d-md-none">{{ __('Toca para seleccionar archivo') }}</span>
                                                </p>
                                                <button type="button" class="btn btn-outline-primary btn-sm" id="selectFotoCarnetBtn">
                                                    <i class="fas fa-folder-open me-2"></i>
                                                    {{ __('Seleccionar Archivo') }}
                                                </button>
                                            </div>
                                            <input type="file" 
                                                   id="foto_carnet" 
                                                   name="foto_carnet" 
                                                   accept="image/*" 
                                                   class="file-input"
                                                   style="display: none;">
                                        </div>
                                        <div class="file-preview" id="fotoCarnetPreview" style="display: none;">
                                            <img id="fotoCarnetImage" src="" alt="Preview" class="img-fluid rounded">
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeFotoCarnetBtn">
                                                <i class="fas fa-trash me-1"></i>
                                                {{ __('Remover') }}
                                            </button>
                                        </div>
                                    </div>
                                    @error('foto_carnet')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto_cedula" class="form-label fw-semibold">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        {{ __('Foto Cédula') }}
                                    </label>
                                    <div class="file-upload-container">
                                        <div class="file-upload-area" id="fotoCedulaArea">
                                            <div class="file-upload-content">
                                                <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                                <h5 class="text-muted mb-2">{{ __('Arrastra la foto aquí') }}</h5>
                                                <p class="text-muted small mb-3">
                                                    <span class="d-none d-md-inline">{{ __('o haz clic para seleccionar') }}</span>
                                                    <span class="d-md-none">{{ __('Toca para seleccionar archivo') }}</span>
                                                </p>
                                                <button type="button" class="btn btn-outline-primary btn-sm" id="selectFotoCedulaBtn">
                                                    <i class="fas fa-folder-open me-2"></i>
                                                    {{ __('Seleccionar Archivo') }}
                                                </button>
                                            </div>
                                            <input type="file" 
                                                   id="foto_cedula" 
                                                   name="foto_cedula" 
                                                   accept="image/*" 
                                                   class="file-input"
                                                   style="display: none;">
                                        </div>
                                        <div class="file-preview" id="fotoCedulaPreview" style="display: none;">
                                            <img id="fotoCedulaImage" src="" alt="Preview" class="img-fluid rounded">
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeFotoCedulaBtn">
                                                <i class="fas fa-trash me-1"></i>
                                                {{ __('Remover') }}
                                            </button>
                                        </div>
                                    </div>
                                    @error('foto_cedula')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto_identificacion" class="form-label fw-semibold">
                                        <i class="fas fa-id-badge me-2 text-primary"></i>
                                        {{ __('Foto Identificación') }}
                                    </label>
                                    <div class="file-upload-container">
                                        <div class="file-upload-area" id="fotoIdentificacionArea">
                                            <div class="file-upload-content">
                                                <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                                <h5 class="text-muted mb-2">{{ __('Arrastra la foto aquí') }}</h5>
                                                <p class="text-muted small mb-3">
                                                    <span class="d-none d-md-inline">{{ __('o haz clic para seleccionar') }}</span>
                                                    <span class="d-md-none">{{ __('Toca para seleccionar archivo') }}</span>
                                                </p>
                                                <button type="button" class="btn btn-outline-primary btn-sm" id="selectFotoIdentificacionBtn">
                                                    <i class="fas fa-folder-open me-2"></i>
                                                    {{ __('Seleccionar Archivo') }}
                                                </button>
                                            </div>
                                            <input type="file" 
                                                   id="foto_identificacion" 
                                                   name="foto_identificacion" 
                                                   accept="image/*" 
                                                   class="file-input"
                                                   style="display: none;">
                                        </div>
                                        <div class="file-preview" id="fotoIdentificacionPreview" style="display: none;">
                                            <img id="fotoIdentificacionImage" src="" alt="Preview" class="img-fluid rounded">
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeFotoIdentificacionBtn">
                                                <i class="fas fa-trash me-1"></i>
                                                {{ __('Remover') }}
                                            </button>
                                        </div>
                                    </div>
                                    @error('foto_identificacion')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                            </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="form-group mb-5">
                            <label for="observacion" class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>
                                {{ __('Observaciones') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-comment text-muted"></i>
                                </span>
                                <textarea class="form-control border-start-0 @error('observacion') is-invalid @enderror" 
                                          id="observacion" 
                                          name="observacion" 
                                          rows="3"
                                          placeholder="Observaciones adicionales sobre el jugador...">{{ old('observacion') }}</textarea>
                            </div>
                            @error('observacion')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <a href="{{ route('jugadores.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold submit-btn">
                                <i class="fas fa-save me-2"></i>
                                {{ __('Guardar Jugador') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Section -->
            
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #8F0000;
    --secondary-color: #6B0000;
    --accent-color: #B30000;
    --text-dark: #2d3748;
    --text-light: #718096;
    --white: #ffffff;
    --shadow-light: rgba(0, 0, 0, 0.1);
    --shadow-medium: rgba(0, 0, 0, 0.15);
    --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, var(--secondary-color) 100%);
}

.page-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: var(--white);
    font-size: 2rem;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
}

.form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.section-header {
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 1rem;
}

.section-header h5 {
    color: var(--text-dark);
    margin: 0;
}

.form-label {
    color: var(--text-dark);
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

.input-group {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.input-group:focus-within {
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.input-group-text {
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: var(--text-light);
    font-size: 0.9rem;
}

.form-control, .form-select {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: var(--white);
}

.form-control::placeholder {
    color: #a0aec0;
    font-size: 0.9rem;
}

/* File Upload Styles */
.file-upload-container {
    position: relative;
}

.file-upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    user-select: none;
}

.file-upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(102, 126, 234, 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
}

.file-upload-area.dragover {
    border-color: var(--primary-color);
    background: rgba(102, 126, 234, 0.1);
    transform: scale(1.02);
}

.file-upload-content {
    pointer-events: auto;
}

.file-preview {
    text-align: center;
    padding: 1rem;
    border-radius: 12px;
    background: #f8fafc;
}

.file-preview img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Button Styles */
.btn {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: var(--gradient-primary);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #e2e8f0;
    color: var(--text-dark);
}

.btn-outline-secondary:hover {
    background: #f8fafc;
    border-color: var(--text-light);
    transform: translateY(-2px);
}

.btn-outline-danger {
    border: 2px solid #fed7d7;
    color: #e53e3e;
}

.btn-outline-danger:hover {
    background: #e53e3e;
    color: var(--white);
    transform: translateY(-2px);
}

.info-item {
    padding: 1rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.2);
}

.info-item i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

/* Loading animation for button */
.submit-btn.loading {
    position: relative;
    color: transparent;
}

.submit-btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid var(--white);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Form validation styles */
.form-control.is-invalid, .form-select.is-invalid {
    border-color: #e53e3e;
    box-shadow: 0 0 0 0.2rem rgba(229, 62, 62, 0.25);
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-card {
        margin: 1rem;
        border-radius: 16px;
    }
    
    .page-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    
    .form-control, .form-select {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn {
        padding: 0.75rem 1.25rem;
    }
    
    .file-upload-area {
        padding: 1rem;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .file-upload-content {
        width: 100%;
    }
    
    .file-upload-area:active {
        transform: scale(0.98);
        background: rgba(102, 126, 234, 0.1);
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0 1rem;
    }
    
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .info-item {
        padding: 0.75rem;
    }
    
    .info-item i {
        font-size: 1.25rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        width: 100%;
    }
    
    .file-upload-area {
        padding: 0.75rem;
        min-height: 80px;
    }
    
    .file-upload-content h5 {
        font-size: 0.9rem;
    }
    
    .file-upload-content p {
        font-size: 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload functionality for all file inputs
    const fileUploads = [
        { area: 'fotoCarnetArea', input: 'foto_carnet', btn: 'selectFotoCarnetBtn', preview: 'fotoCarnetPreview', image: 'fotoCarnetImage', remove: 'removeFotoCarnetBtn' },
        { area: 'fotoCedulaArea', input: 'foto_cedula', btn: 'selectFotoCedulaBtn', preview: 'fotoCedulaPreview', image: 'fotoCedulaImage', remove: 'removeFotoCedulaBtn' },
        { area: 'fotoIdentificacionArea', input: 'foto_identificacion', btn: 'selectFotoIdentificacionBtn', preview: 'fotoIdentificacionPreview', image: 'fotoIdentificacionImage', remove: 'removeFotoIdentificacionBtn' }
    ];

    fileUploads.forEach(upload => {
        const fileUploadArea = document.getElementById(upload.area);
        const fileInput = document.getElementById(upload.input);
        const selectFileBtn = document.getElementById(upload.btn);
        const filePreview = document.getElementById(upload.preview);
        const previewImage = document.getElementById(upload.image);
        const removeFileBtn = document.getElementById(upload.remove);

        if (fileUploadArea && fileInput && selectFileBtn && filePreview && previewImage && removeFileBtn) {
            // Select file button
            selectFileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                fileInput.click();
            });
            
            // Make entire upload area clickable
            fileUploadArea.addEventListener('click', function(e) {
                if (e.target !== selectFileBtn && !selectFileBtn.contains(e.target)) {
                    fileInput.click();
                }
            });

            // File input change
            fileInput.addEventListener('change', function() {
                handleFileSelect(this.files[0], fileUploadArea, filePreview, previewImage);
            });

            // Drag and drop functionality
            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            fileUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFileSelect(files[0], fileUploadArea, filePreview, previewImage);
                }
            });

            // Remove file
            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.style.display = 'none';
                fileUploadArea.style.display = 'block';
            });
        }
    });

    // Handle file selection
    function handleFileSelect(file, uploadArea, previewArea, imageElement) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imageElement.src = e.target.result;
                uploadArea.style.display = 'none';
                previewArea.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            alert('Por favor selecciona un archivo de imagen válido.');
        }
    }

    // Form submission with loading state
    const createForm = document.querySelector('.create-form');
    const submitBtn = document.querySelector('.submit-btn');
    
    if (createForm && submitBtn) {
        createForm.addEventListener('submit', function() {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    }
    
    // Input focus effects
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // Auto-hide validation messages
    const errorMessages = document.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 300);
        }, 5000);
    });
    
    // Add touch feedback for mobile
    if ('ontouchstart' in window) {
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
        
        // Add touch feedback for file upload areas
        fileUploads.forEach(upload => {
            const fileUploadArea = document.getElementById(upload.area);
            if (fileUploadArea) {
                fileUploadArea.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                    this.style.background = 'rgba(102, 126, 234, 0.1)';
                });
                
                fileUploadArea.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                    this.style.background = '#f8fafc';
                });
            }
        });
    }
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && document.activeElement.tagName === 'INPUT') {
            const form = document.querySelector('.create-form');
            if (form) {
                form.submit();
            }
        }
    });
    // Teléfono format validation
    [telefonoInput, telefonoRepresentanteInput].forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                let value = this.value.replace(/[^0-9-]/g, '');
                if (value.length >= 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4);
                }
                this.value = value;
            });
        }
    });
    
    // Character counters
    function addCharacterCounter(input, maxLength) {
        const counter = document.createElement('small');
        counter.className = 'text-muted mt-1 d-block';
        counter.textContent = `${input.value.length}/${maxLength}`;
        
        input.parentElement.appendChild(counter);
        
        input.addEventListener('input', function() {
            counter.textContent = `${this.value.length}/${maxLength}`;
            if (this.value.length > maxLength * 0.8) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
            }
        });
    }
    
    if (document.getElementById('nombre')) addCharacterCounter(document.getElementById('nombre'), 100);
    if (document.getElementById('direccion')) addCharacterCounter(document.getElementById('direccion'), 200);
    if (document.getElementById('nombre_representante')) addCharacterCounter(document.getElementById('nombre_representante'), 100);
    if (document.getElementById('observacion')) addCharacterCounter(document.getElementById('observacion'), 500);
    });
</script>
@endsection
