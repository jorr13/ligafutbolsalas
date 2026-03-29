@extends('layouts.app')

@section('styles')
<style>
    .entrenador-selector {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .comment-card {
        border: none;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.2s ease;
        margin-bottom: 1rem;
    }

    .comment-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .comment-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        color: #fff;
        flex-shrink: 0;
    }

    .comment-avatar.positivo {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .comment-avatar.negativo {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
    }

    .reply-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        color: #fff;
        background: linear-gradient(135deg, #6c757d, #495057);
        flex-shrink: 0;
    }

    .comment-body {
        flex: 1;
        min-width: 0;
    }

    .comment-author {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2d3748;
    }

    .comment-time {
        font-size: 0.78rem;
        color: #718096;
    }

    .comment-text {
        font-size: 0.92rem;
        color: #4a5568;
        line-height: 1.6;
        margin-top: 0.35rem;
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

    .reply-thread {
        margin-left: 54px;
        padding-left: 1rem;
        border-left: 2px solid #e9ecef;
    }

    .reply-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        margin-bottom: 0.65rem;
    }

    .btn-reply-toggle {
        font-size: 0.82rem;
        font-weight: 600;
        color: #6c757d;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn-reply-toggle:hover {
        color: #8F0000;
    }

    .reply-form {
        display: none;
        margin-top: 0.75rem;
    }

    .reply-form.show {
        display: block;
    }

    .new-comment-card {
        border: 2px dashed #dee2e6;
        border-radius: 14px;
        background: #fdfdfe;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: border-color 0.3s;
    }

    .new-comment-card:focus-within {
        border-color: #8F0000;
    }

    .entrenador-profile {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #8F0000, #6B0000);
        border-radius: 14px;
        color: #fff;
        margin-bottom: 1.5rem;
    }

    .entrenador-profile .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 0.75rem;
    }

    .entrenador-profile .profile-avatar-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 2rem;
    }

    .comment-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.82rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #718096;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #cbd5e0;
    }

    .tipo-selector .btn {
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.4rem 1.2rem;
    }

    .tipo-selector .btn-outline-success.active,
    .tipo-selector .btn-check:checked + .btn-outline-success {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .tipo-selector .btn-outline-danger.active,
    .tipo-selector .btn-check:checked + .btn-outline-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }

    @media (max-width: 768px) {
        .reply-thread {
            margin-left: 28px;
            padding-left: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-comments text-danger me-2"></i>{{ __('Comentarios') }}
            </h2>
            <p class="text-muted mb-0">{{ __('Opiniones sobre entrenadores de la liga') }}</p>
        </div>
        @if(auth()->user()->rol_id === 'administrador')
            <a href="{{ route('comentarios.pendientes') }}" class="btn btn-outline-warning mt-2 mt-md-0 position-relative pe-3">
                <i class="fas fa-clock me-1"></i>{{ __('Pendientes de aprobación') }}
                @if(($comentariosPendientesCount ?? 0) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" title="{{ __('Comentarios pendientes de moderación') }}">
                        {{ $comentariosPendientesCount > 99 ? '99+' : $comentariosPendientesCount }}
                        <span class="visually-hidden">{{ __('comentarios pendientes') }}</span>
                    </span>
                @endif
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Selector de entrenador --}}
    <div class="entrenador-selector">
        <form method="GET" action="{{ route('comentarios.index') }}">
            <label class="form-label fw-semibold mb-2">
                <i class="fas fa-user-tie me-1"></i>{{ __('Seleccionar entrenador') }}
            </label>
            <div class="d-flex flex-column flex-md-row gap-2">
                <select name="entrenador_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- {{ __('Elige un entrenador para ver o dejar comentarios') }} --</option>
                    @foreach($entrenadores as $ent)
                        <option value="{{ $ent->id }}" {{ request('entrenador_id') == $ent->id ? 'selected' : '' }}>
                            {{ $ent->nombre }} {{ $ent->nombre_club ? '('.$ent->nombre_club.')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if($entrenadorSeleccionado)
        <div class="row">
            {{-- Perfil del entrenador --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="entrenador-profile">
                    @if($entrenadorSeleccionado->foto_carnet)
                        <img src="{{ asset('storage/' . $entrenadorSeleccionado->foto_carnet) }}" alt="" class="profile-avatar d-block mx-auto">
                    @else
                        <div class="profile-avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <h5 class="fw-bold mb-1">{{ $entrenadorSeleccionado->nombre }}</h5>
                    @if($entrenadorSeleccionado->club)
                        <p class="mb-2 opacity-75"><i class="fas fa-building me-1"></i>{{ $entrenadorSeleccionado->club->nombre }}</p>
                    @endif
                    <div class="comment-count-badge mx-auto">
                        <i class="fas fa-comments"></i>
                        {{ $comentarios->total() ?? 0 }} {{ __('comentarios') }}
                    </div>
                </div>
            </div>

            {{-- Columna de comentarios --}}
            <div class="col-lg-8">

                {{-- Formulario para nuevo comentario --}}
                @if(in_array(auth()->user()->rol_id, ['entrenador', 'arbitro', 'administrador']))
                    <div class="new-comment-card">
                        <h6 class="fw-bold mb-3"><i class="fas fa-pen me-2 text-muted"></i>{{ __('Dejar un comentario') }}</h6>
                        <form method="POST" action="{{ route('comentarios.store') }}">
                            @csrf
                            <input type="hidden" name="destinatario_id" value="{{ $entrenadorSeleccionado->id }}">

                            <div class="tipo-selector mb-3 d-flex gap-2">
                                <input type="radio" class="btn-check" name="tipo" id="tipo_positivo" value="positivo" autocomplete="off" {{ old('tipo', 'positivo') === 'positivo' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success btn-sm" for="tipo_positivo">
                                    <i class="fas fa-thumbs-up me-1"></i>{{ __('Positivo') }}
                                </label>

                                <input type="radio" class="btn-check" name="tipo" id="tipo_negativo" value="negativo" autocomplete="off" {{ old('tipo') === 'negativo' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger btn-sm" for="tipo_negativo">
                                    <i class="fas fa-thumbs-down me-1"></i>{{ __('Negativo') }}
                                </label>
                            </div>

                            <div class="mb-3">
                                <textarea name="contenido" class="form-control @error('contenido') is-invalid @enderror"
                                    rows="3" maxlength="1000"
                                    placeholder="{{ __('Escribe tu opinión sobre este entrenador...') }}"
                                    required>{{ old('contenido') }}</textarea>
                                @error('contenido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-sm px-4" style="background: #8F0000; color: #fff;">
                                    <i class="fas fa-paper-plane me-1"></i>{{ __('Enviar comentario') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Lista de comentarios aprobados --}}
                @if($comentarios->count() > 0)
                    @foreach($comentarios as $comentario)
                        <div class="comment-card p-3">
                            <div class="d-flex gap-3">
                                <div class="comment-avatar {{ $comentario->tipo }}">
                                    {{ strtoupper(substr($comentario->autor->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="comment-body">
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                        <span class="comment-author">{{ $comentario->autor->name ?? __('Usuario') }}</span>
                                        <span class="tipo-badge {{ $comentario->tipo }}">
                                            @if($comentario->tipo === 'positivo')
                                                <i class="fas fa-thumbs-up me-1"></i>{{ __('Positivo') }}
                                            @else
                                                <i class="fas fa-thumbs-down me-1"></i>{{ __('Negativo') }}
                                            @endif
                                        </span>
                                        <span class="comment-time">{{ $comentario->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="comment-text mb-2">{{ $comentario->contenido }}</p>

                                    <div class="d-flex align-items-center gap-3">
                                        @if($comentario->respuestas->count() > 0)
                                            <button class="btn-reply-toggle" onclick="toggleReplies({{ $comentario->id }})">
                                                <i class="fas fa-caret-down me-1" id="caret-{{ $comentario->id }}"></i>
                                                {{ $comentario->respuestas->count() }} {{ $comentario->respuestas->count() === 1 ? __('respuesta') : __('respuestas') }}
                                            </button>
                                        @endif

                                        @if(in_array(auth()->user()->rol_id, ['entrenador', 'arbitro', 'administrador']))
                                            <button class="btn-reply-toggle" onclick="toggleReplyForm({{ $comentario->id }})">
                                                <i class="fas fa-reply me-1"></i>{{ __('Responder') }}
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Formulario de respuesta --}}
                                    @if(in_array(auth()->user()->rol_id, ['entrenador', 'arbitro', 'administrador']))
                                        <div class="reply-form" id="reply-form-{{ $comentario->id }}">
                                            <form method="POST" action="{{ route('comentarios.responder', $comentario->id) }}">
                                                @csrf
                                                <div class="d-flex gap-2 mt-2">
                                                    <input type="text" name="contenido" class="form-control form-control-sm"
                                                        placeholder="{{ __('Escribe una respuesta...') }}" maxlength="1000" required>
                                                    <button type="submit" class="btn btn-sm" style="background: #8F0000; color: #fff; white-space: nowrap;">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Respuestas anidadas --}}
                            @if($comentario->respuestas->count() > 0)
                                <div class="reply-thread" id="replies-{{ $comentario->id }}" style="display: none;">
                                    @foreach($comentario->respuestas as $respuesta)
                                        <div class="reply-card">
                                            <div class="d-flex gap-2">
                                                <div class="reply-avatar">
                                                    {{ strtoupper(substr($respuesta->autor->name ?? '?', 0, 1)) }}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-semibold" style="font-size: 0.83rem;">{{ $respuesta->autor->name ?? __('Usuario') }}</span>
                                                        <span class="comment-time">{{ $respuesta->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="mb-0 mt-1" style="font-size: 0.88rem; color: #4a5568;">{{ $respuesta->contenido }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-3">
                        {{ $comentarios->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-comment-slash d-block"></i>
                        <h5 class="fw-semibold mb-2">{{ __('Sin comentarios aún') }}</h5>
                        <p class="mb-0">{{ __('Sé el primero en dejar una opinión sobre este entrenador.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-hand-pointer d-block"></i>
            <h5 class="fw-semibold mb-2">{{ __('Selecciona un entrenador') }}</h5>
            <p class="mb-0">{{ __('Elige un entrenador del listado para ver y dejar comentarios.') }}</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function toggleReplies(id) {
    const el = document.getElementById('replies-' + id);
    const caret = document.getElementById('caret-' + id);
    if (!el) return;
    const visible = el.style.display !== 'none';
    el.style.display = visible ? 'none' : 'block';
    if (caret) {
        caret.classList.toggle('fa-caret-down', visible);
        caret.classList.toggle('fa-caret-up', !visible);
    }
}

function toggleReplyForm(id) {
    const el = document.getElementById('reply-form-' + id);
    if (!el) return;
    el.classList.toggle('show');
    if (el.classList.contains('show')) {
        el.querySelector('input[name="contenido"]')?.focus();
    }
}
</script>
@endsection
