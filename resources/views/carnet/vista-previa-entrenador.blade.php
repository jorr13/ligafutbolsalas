@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-id-card"></i>
                        Vista previa del carnet — {{ $entrenador->nombre }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><strong>Datos del entrenador</strong></h6>
                            <p><strong>Nombre:</strong> {{ $entrenador->nombre }}</p>
                            <p><strong>Cédula:</strong> {{ $entrenador->cedula }}</p>
                            <p><strong>Club:</strong> {{ $entrenador->club->nombre ?? 'N/A' }}</p>
                            <p><strong>Estado:</strong> {{ ucfirst($entrenador->estatus ?? '') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Contacto</strong></h6>
                            <p><strong>Email:</strong> {{ $entrenador->email ?? 'N/A' }}</p>
                            <p><strong>Teléfono:</strong> {{ $entrenador->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <h5>Vista previa del carnet</h5>
                        <div class="border p-3 d-inline-block" style="background: #f8f9fa;">
                            @php
                                $imagenesCorregidas = ['foto' => null, 'logo' => null];
                            @endphp
                            @include('carnet.template-entrenador')
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('entrenadores.carnet', $entrenador->id) }}"
                           class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-download"></i>
                            Descargar carnet PDF
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i>
                            Volver
                        </a>
                    </div>

                    @if(!$entrenador->foto_carnet)
                    <div class="alert alert-warning mt-4 mb-0">
                        <strong>Nota:</strong> Este entrenador no tiene foto de carnet cargada.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
