@extends('layouts.app')

@section('styles')
<style>
    .mod-card {
        border: none;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        margin-bottom: 1rem;
        border-left: 4px solid #ffc107;
        transition: box-shadow 0.2s;
    }

    .mod-card:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
    }

    .mod-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: #fff;
        flex-shrink: 0;
    }

    .mod-avatar.positivo {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .mod-avatar.negativo {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
    }

    .mod-avatar.respuesta {
        background: linear-gradient(135deg, #6c757d, #495057);
    }

    .tipo-badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 20px;
    }

    .tipo-badge.positivo {
        background-color: #d4edda;
        color: #155724;
    }

    .tipo-badge.negativo {
        background-color: #f8d7da;
        color: #721c24;
    }

    .parent-preview {
        background: #f0f0f0;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.82rem;
        color: #555;
        margin-bottom: 0.5rem;
        border-left: 3px solid #adb5bd;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: #718096;
    }

    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: #cbd5e0;
    }
</style>
@endsection

@section('content')
<div class="container">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-shield-alt text-warning me-2"></i>{{ __('Moderación de comentarios') }}
            </h2>
            <p class="text-muted mb-0">{{ __('Revisa y aprueba o rechaza los comentarios pendientes') }}</p>
        </div>
        <a href="{{ route('comentarios.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">
            <i class="fas fa-arrow-left me-1"></i>{{ __('Volver a comentarios') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($comentarios->count() > 0)
        @foreach($comentarios as $comentario)
            <div class="mod-card p-3">
                <div class="d-flex gap-3">
                    <div class="mod-avatar {{ $comentario->parent_id ? 'respuesta' : $comentario->tipo }}">
                        {{ strtoupper(substr($comentario->autor->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="fw-bold" style="font-size: 0.9rem;">{{ $comentario->autor->name ?? __('Usuario') }}</span>
                            @if($comentario->parent_id)
                                <span class="badge bg-secondary" style="font-size: 0.68rem;">{{ __('Respuesta') }}</span>
                            @endif
                            <span class="tipo-badge {{ $comentario->tipo }}">
                                @if($comentario->tipo === 'positivo')
                                    <i class="fas fa-thumbs-up me-1"></i>{{ __('Positivo') }}
                                @else
                                    <i class="fas fa-thumbs-down me-1"></i>{{ __('Negativo') }}
                                @endif
                            </span>
                            <span style="font-size: 0.78rem; color: #718096;">{{ $comentario->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="mb-1" style="font-size: 0.82rem; color: #718096;">
                            <i class="fas fa-user-tie me-1"></i>{{ __('Sobre:') }}
                            <strong>{{ $comentario->destinatario->nombre ?? __('Entrenador eliminado') }}</strong>
                        </div>

                        @if($comentario->padre)
                            <div class="parent-preview">
                                <i class="fas fa-reply fa-flip-horizontal me-1"></i>
                                <strong>{{ $comentario->padre->autor->name ?? '' }}:</strong>
                                {{ Str::limit($comentario->padre->contenido, 120) }}
                            </div>
                        @endif

                        <p class="mb-3" style="font-size: 0.92rem; color: #2d3748; line-height: 1.6;">{{ $comentario->contenido }}</p>

                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('comentarios.aprobar', $comentario->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <i class="fas fa-check me-1"></i>{{ __('Aprobar') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('comentarios.rechazar', $comentario->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm px-3">
                                    <i class="fas fa-times me-1"></i>{{ __('Rechazar') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $comentarios->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-check-double d-block"></i>
            <h5 class="fw-semibold mb-2">{{ __('No hay comentarios pendientes') }}</h5>
            <p class="mb-0">{{ __('Todos los comentarios han sido revisados.') }}</p>
        </div>
    @endif
</div>
@endsection
