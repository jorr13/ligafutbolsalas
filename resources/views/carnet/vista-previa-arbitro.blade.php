@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-id-card"></i>
                        Vista previa del carnet — {{ $arbitro->nombre }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><strong>Datos del árbitro</strong></h6>
                            <p><strong>Nombre:</strong> {{ $arbitro->nombre }}</p>
                            <p><strong>Cédula:</strong> {{ $arbitro->cedula }}</p>
                            <p><strong>Estado:</strong> {{ ucfirst($arbitro->estatus ?? '') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Contacto</strong></h6>
                            <p><strong>Email:</strong> {{ $arbitro->email ?? 'N/A' }}</p>
                            <p><strong>Teléfono:</strong> {{ $arbitro->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <h5>Vista previa del carnet</h5>
                        <div class="border p-3 d-inline-block" style="background: #f8f9fa;">
                            @php
                                $imagenesCorregidas = ['foto' => null];
                            @endphp
                            @include('carnet.template-arbitro')
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('arbitros.carnet', $arbitro->id) }}"
                           class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-download"></i>
                            Descargar carnet PDF
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i>
                            Volver
                        </a>
                    </div>

                    @if(!$arbitro->foto_carnet)
                    <div class="alert alert-warning mt-4 mb-0">
                        <strong>Nota:</strong> Este árbitro no tiene foto de carnet cargada.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
