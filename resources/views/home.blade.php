@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Welcome Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <h2 class="mb-3">{{ __('¡Bienvenido!') }}</h2>
                    <p class="text-muted mb-0">{{ __('Has iniciado sesión correctamente') }}</p>
                </div>
            </div>
        </div>
  
        <!-- Quick Actions -->
        <div class="col-12">
            <div class="row g-3">
                @if(auth()->user()->rol_id=="entrenador")
                    <div class="col-6 col-md-4">
                        <a href="{{ route('jugadores.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-museum mb-2 fs-3 text-primary"></i>
                                <h5 class="card-title mb-0">Mis Jugadores</h5>
                            </div>
                        </a>
                    </div>
                @endif
                @if(auth()->user()->rol_id=="administrador")
                    <div class="col-6 col-md-4">
                        <a href="{{ route('clubes.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-museum mb-2 fs-3 text-primary"></i>
                                <h5 class="card-title mb-0">Clubes</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('categorias.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-qrcode mb-2 fs-3 text-success"></i>
                                <h5 class="card-title mb-0">Categorias</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('entrenadores.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-qrcode mb-2 fs-3 text-success"></i>
                                <h5 class="card-title mb-0">Entrenadores</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('jugadores.indexpendientes') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                            @if($jugadores > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{$jugadores}}+
                                <span class="visually-hidden">pendiente</span>
                            </span>
                            @endif
                            <div class="card-body text-center p-3">
                         
                                <i class="fas fa-qrcode mb-2 fs-3 text-success"></i>
                                <h5 class="card-title mb-0">Jugadores Pendientes</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4">
                        <a href="{{ route('usuarios.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-qrcode mb-2 fs-3 text-success"></i>
                                <h5 class="card-title mb-0">Usuarios</h5>
                            </div>
                        </a>
                    </div>
                @endif
       
            </div>
        </div>
    </div>
</div>
@endsection
