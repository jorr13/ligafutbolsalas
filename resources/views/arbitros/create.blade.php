@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="page-icon mb-3">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2">{{ __('Nuevo Arbitro') }}</h2>
                <p class="text-muted mb-0">{{ __('Registra un nuevo arbitro en la Liga de Fútbol Sala') }}</p>
                </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-lg form-card">
                <div class="card-body p-5">
                    <form action="{{ route('arbitros.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
                        @csrf
                        
                        <!-- Nombre del Arbitro -->
                        <div class="form-group mb-4">
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

                        <!-- Cédula -->
                        <div class="form-group mb-4">
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
                                       placeholder="Ej: V-12345678"
                                       value="{{ old('cedula') }}">
                            </div>
                            @error('cedula')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group mb-4">
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
                                       required 
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

                        <!-- Dirección -->
                        <div class="form-group mb-4">
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
                                       required 
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

                        <!-- Email -->
                        <div class="form-group mb-4">
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
                                       required 
                                       placeholder="Ej: entrenador@email.com"
                                       value="{{ old('email') }}">
                        </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                        </div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group mb-4">
                            <label for="pass" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>
                                {{ __('Contraseña') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0 @error('pass') is-invalid @enderror" 
                                       id="pass" 
                                       name="pass" 
                                       required 
                                       placeholder="••••••••">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                        </div>
                            @error('pass')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                        </div>
                            @enderror
                        </div>

                        <!-- Foto Carnet -->
                        <div class="form-group mb-4">
                            <label for="foto_carnet" class="form-label fw-semibold">
                                <i class="fas fa-camera me-2 text-primary"></i>
                                {{ __('Foto Carnet') }}
                            </label>
                            <div class="file-upload-container">
                                <div class="file-upload-area" id="fotoCarnetUploadArea">
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                        <h5 class="text-muted mb-2">{{ __('Arrastra tu foto aquí') }}</h5>
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
                                    <img id="fotoCarnetPreviewImage" src="" alt="Preview" class="img-fluid rounded">
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

                        <!-- Foto Cédula -->
                        <div class="form-group mb-4">
                            <label for="foto_cedula" class="form-label fw-semibold">
                                <i class="fas fa-id-card me-2 text-primary"></i>
                                {{ __('Foto Cédula') }}
                            </label>
                            <div class="file-upload-container">
                                <div class="file-upload-area" id="fotoCedulaUploadArea">
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                        <h5 class="text-muted mb-2">{{ __('Arrastra tu foto aquí') }}</h5>
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
                                    <img id="fotoCedulaPreviewImage" src="" alt="Preview" class="img-fluid rounded">
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

                        <!-- Archivo CV -->
                        <div class="form-group mb-5">
                            <label for="archivo_cv" class="form-label fw-semibold">
                                <i class="fas fa-file-pdf me-2 text-primary"></i>
                                {{ __('Archivo CV') }}
                            </label>
                            <div class="file-upload-container">
                                <div class="file-upload-area" id="archivoCvUploadArea">
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt text-primary fs-1 mb-3"></i>
                                        <h5 class="text-muted mb-2">{{ __('Arrastra tu CV aquí') }}</h5>
                                        <p class="text-muted small mb-3">
                                            <span class="d-none d-md-inline">{{ __('o haz clic para seleccionar') }}</span>
                                            <span class="d-md-none">{{ __('Toca para seleccionar archivo') }}</span>
                                        </p>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="selectArchivoCvBtn">
                                            <i class="fas fa-folder-open me-2"></i>
                                            {{ __('Seleccionar Archivo') }}
                                        </button>
                                    </div>
                                    <input type="file" 
                                           id="archivo_cv" 
                                           name="archivo_cv" 
                                           accept=".pdf,.doc,.docx" 
                                           class="file-input"
                                           style="display: none;">
                                </div>
                                <div class="file-preview" id="archivoCvPreview" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger fs-1 me-3"></i>
                                        <div>
                                            <p class="mb-1 fw-semibold" id="archivoCvFileName"></p>
                                            <small class="text-muted" id="archivoCvFileSize"></small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeArchivoCvBtn">
                                        <i class="fas fa-trash me-1"></i>
                                        {{ __('Remover') }}
                                    </button>
                                </div>
                            </div>
                            @error('archivo_cv')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <a href="{{ route('arbitros.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold submit-btn">
                                <i class="fas fa-save me-2"></i>
                                {{ __('Guardar Arbitro') }}
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
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --accent-color: #f093fb;
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

.form-control {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
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
    padding: 2rem;
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
    max-width: 200px;
    max-height: 200px;
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
.form-control.is-invalid {
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
    
    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn {
        padding: 0.75rem 1.25rem;
    }
    
    .file-upload-area {
        padding: 1.5rem;
        min-height: 120px;
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
        padding: 1rem;
        min-height: 100px;
    }
    
    .file-upload-content h5 {
        font-size: 1rem;
    }
    
    .file-upload-content p {
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('pass');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    }

    // File upload functionality for multiple files
    const fileUploadConfigs = [
        {
            uploadArea: 'fotoCarnetUploadArea',
            fileInput: 'foto_carnet',
            selectBtn: 'selectFotoCarnetBtn',
            preview: 'fotoCarnetPreview',
            previewImage: 'fotoCarnetPreviewImage',
            removeBtn: 'removeFotoCarnetBtn',
            accept: 'image/*',
            isImage: true
        },
        {
            uploadArea: 'fotoCedulaUploadArea',
            fileInput: 'foto_cedula',
            selectBtn: 'selectFotoCedulaBtn',
            preview: 'fotoCedulaPreview',
            previewImage: 'fotoCedulaPreviewImage',
            removeBtn: 'removeFotoCedulaBtn',
            accept: 'image/*',
            isImage: true
        },
        {
            uploadArea: 'archivoCvUploadArea',
            fileInput: 'archivo_cv',
            selectBtn: 'selectArchivoCvBtn',
            preview: 'archivoCvPreview',
            fileName: 'archivoCvFileName',
            fileSize: 'archivoCvFileSize',
            removeBtn: 'removeArchivoCvBtn',
            accept: '.pdf,.doc,.docx',
            isImage: false
        }
    ];

    // Initialize file upload for each configuration
    fileUploadConfigs.forEach(config => {
        const uploadArea = document.getElementById(config.uploadArea);
        const fileInput = document.getElementById(config.fileInput);
        const selectBtn = document.getElementById(config.selectBtn);
        const preview = document.getElementById(config.preview);
        const removeBtn = document.getElementById(config.removeBtn);

        if (!uploadArea || !fileInput || !selectBtn || !preview || !removeBtn) return;

        // Select file button
        selectBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            fileInput.click();
        });
        
        // Make entire upload area clickable
        uploadArea.addEventListener('click', function(e) {
            if (e.target !== selectBtn && !selectBtn.contains(e.target)) {
                fileInput.click();
            }
        });

        // File input change
        fileInput.addEventListener('change', function() {
            handleFileSelect(this.files[0], config);
        });

        // Drag and drop functionality
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0], config);
            }
        });

        // Remove file
        removeBtn.addEventListener('click', function() {
            fileInput.value = '';
            preview.style.display = 'none';
            uploadArea.style.display = 'block';
        });
    });

    // Handle file selection
    function handleFileSelect(file, config) {
        if (!file) return;

        // Validate file type
        if (config.isImage && !file.type.startsWith('image/')) {
            alert('Por favor selecciona un archivo de imagen válido.');
            return;
        }

        if (!config.isImage) {
            const allowedTypes = ['.pdf', '.doc', '.docx'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
            if (!allowedTypes.includes(fileExtension)) {
                alert('Por favor selecciona un archivo PDF, DOC o DOCX válido.');
                return;
            }
        }

        if (config.isImage) {
            // Handle image files
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById(config.previewImage);
                previewImage.src = e.target.result;
                document.getElementById(config.uploadArea).style.display = 'none';
                document.getElementById(config.preview).style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            // Handle document files
            const fileName = document.getElementById(config.fileName);
            const fileSize = document.getElementById(config.fileSize);
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            document.getElementById(config.uploadArea).style.display = 'none';
            document.getElementById(config.preview).style.display = 'block';
        }
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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
    const inputs = document.querySelectorAll('.form-control');
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
        fileUploadConfigs.forEach(config => {
            const uploadArea = document.getElementById(config.uploadArea);
            if (uploadArea) {
                uploadArea.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                    this.style.background = 'rgba(102, 126, 234, 0.1)';
                });
                
                uploadArea.addEventListener('touchend', function() {
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
    
    // Real-time validation
    const cedulaInput = document.getElementById('cedula');
    const telefonoInput = document.getElementById('telefono');
    
    // Cédula format validation
    cedulaInput.addEventListener('input', function() {
        let value = this.value.replace(/[^A-Za-z0-9-]/g, '');
        if (value.length > 0) {
            value = value.toUpperCase();
        }
        this.value = value;
    });
    
    // Teléfono format validation
    telefonoInput.addEventListener('input', function() {
        let value = this.value.replace(/[^0-9-]/g, '');
        this.value = value;
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
});
</script>
@endsection
