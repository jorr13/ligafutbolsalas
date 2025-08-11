@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body text-center p-4">
            <h1 class="h3 mb-2 text-blue-dark">{{ $exhibicion->title }}</h1>
            <p class="text-muted mb-0">Códigos QR de la exhibición</p>
        </div>
    </div>

    <!-- QR Codes Sections -->
    @if($contenidoGeneral->isNotEmpty() || $contenidoDependiente->isNotEmpty())
    <div class="accordion" id="accordionQRs">
        <!-- Contenido General -->
        @if($contenidoGeneral->isNotEmpty())
        <div class="accordion-item mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button" 
                        type="button" 
                        data-target="#collapseGeneral">
                    <i class="fas fa-file-alt text-primary me-2"></i>
                    <strong>Contenido General</strong>
                    <span class="badge bg-primary rounded-pill ms-2">{{ $contenidoGeneral->count() }}</span>
                </button>
            </h2>
            <div id="collapseGeneral" class="accordion-collapse collapse show">
                <div class="accordion-body p-4">
                    <div class="row g-4">
                        @foreach ($contenidoGeneral as $general)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body text-center p-3">
                                    <!-- QR Code -->
                                    <div class="mb-3">
                                        <img src="data:image/png;base64,{{ $general->qr }}" 
                                             alt="QR {{ $general->title }}"
                                             class="img-fluid"
                                             style="max-width: 180px;">
                                    </div>
                                    <!-- Title and Actions -->
                                    <h6 class="card-title mb-3 text-truncate text-blue-dark">{{ $general->title }}</h6>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('contenidos.ver', ['url' => $exhibicion->descrip_url, 'contenido' => $general->id]) }}" 
                                           class="btn btn-outline-primary btn-sm"
                                           target="_blank">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </a>
                                        <button class="btn btn-outline-success btn-sm download-qr" 
                                                data-qr="{{ $general->qr }}"
                                                data-title="{{ $general->title }}">
                                            <i class="fas fa-download me-1"></i>Descargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Contenido Dependiente -->
        @if($contenidoDependiente->isNotEmpty())
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" 
                        type="button" 
                        data-target="#collapseDependiente">
                    <i class="fas fa-link text-info me-2"></i>
                    <strong>Contenido Dependiente</strong>
                    <span class="badge bg-info rounded-pill ms-2">{{ $contenidoDependiente->count() }}</span>
                </button>
            </h2>
            <div id="collapseDependiente" class="accordion-collapse collapse">
                <div class="accordion-body p-4">
                    <div class="row g-4">
                        @foreach ($contenidoDependiente as $dependiente)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body text-center p-3">
                                    <!-- QR Code -->
                                    <div class="mb-3">
                                        <img src="data:image/png;base64,{{ $dependiente->qr }}" 
                                             alt="QR {{ $dependiente->title }}"
                                             class="img-fluid"
                                             style="max-width: 180px;">
                                    </div>
                                    <!-- Title and Actions -->
                                    <h6 class="card-title mb-3 text-truncate text-blue-dark">{{ $dependiente->title }}</h6>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('contenidos.ver', ['url' => $exhibicion->descrip_url, 'contenido' => $dependiente->id]) }}" 
                                           class="btn btn-outline-primary btn-sm"
                                           target="_blank">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </a>
                                        <button class="btn btn-outline-success btn-sm download-qr" 
                                                data-qr="{{ $dependiente->qr }}"
                                                data-title="{{ $dependiente->title }}">
                                            <i class="fas fa-download me-1"></i>Descargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
        <p class="text-muted">No hay códigos QR disponibles para esta exhibición</p>
    </div>
    @endif
</div>

<!-- Script for QR Download -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de descargas de QR
    document.querySelectorAll('.download-qr').forEach(button => {
        button.addEventListener('click', function() {
            const qrData = this.dataset.qr;
            const title = this.dataset.title;
            
            // Create a temporary canvas
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = function() {
                // Set canvas size to image size
                canvas.width = img.width;
                canvas.height = img.height;
                
                // Draw image on canvas
                ctx.drawImage(img, 0, 0);
                
                // Create temporary link for download
                const link = document.createElement('a');
                link.download = `QR-${title.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            };
            
            // Load the image from base64
            img.src = 'data:image/png;base64,' + qrData;
        });
    });

    // Manejo del acordeón
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const target = document.querySelector(targetId);
            
            // Toggle button state
            this.classList.toggle('collapsed');
            
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


