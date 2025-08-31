@extends('layouts.app')
@section('content')

<style>
    .asignar-categoria-container {
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }
    
    .categoria-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .categoria-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .categoria-nombre {
        font-weight: 600;
        color: #495057;
        margin: 0;
    }
    
    .btn-modern {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-modern:hover::before {
        left: 100%;
    }
    
    .btn-danger-modern {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
    }
    
    .btn-danger-modern:hover {
        background: linear-gradient(135deg, #ff5252 0%, #d32f2f 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary-modern:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .form-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 0.75rem 1rem;
        background: white;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .form-select-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }
    
    .form-label-modern {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .club-title {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        font-size: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .asignar-categoria-container {
            padding: 1rem 0;
        }
        
        .glass-card {
            margin-bottom: 1rem;
        }
        
        .categoria-item {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .btn-modern {
            width: 100%;
        }
        
        .d-flex.justify-content-end {
            flex-direction: column;
            gap: 1rem;
        }
        
        .d-flex.justify-content-end .btn {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .container {
            padding: 0 1rem;
        }
        
        .card-header-modern {
            padding: 1rem;
        }
        
        .club-title {
            font-size: 1.25rem;
        }
    }
</style>

<div class="asignar-categoria-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h1 class="club-title">
                        <i class="fas fa-shield-alt me-3"></i>
                        Gestión de Categorías - {{ $clubes->nombre }}
                    </h1>
                    <p class="text-white opacity-75">
                        <i class="fas fa-info-circle me-2"></i>
                        Asigna o elimina categorías para este club
                    </p>
                </div>
                
                <div class="row g-4">
                    <!-- Categorías Asignadas -->
        <div class="col-md-4">
                        <div class="glass-card h-100">
                            <div class="card-header-modern">
                                <h5 class="mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Categorías Asignadas
                                </h5>
                        </div>
                            <div class="card-body p-4">
                                @if($categoriasAsign && count($categoriasAsign) > 0)
                                    <div class="categorias-list">
                            @foreach ($categoriasAsign as $asignadas)
                                            <div class="categoria-item">
                                                <div>
                                                    <h6 class="categoria-nombre mb-1">
                                                        <i class="fas fa-tag me-2 text-primary"></i>
                                    {{ $asignadas->nombre_categoria }}
                                                    </h6>
                                                </div>
                                <form action="{{ route('clubes.deleteasignar') }}" 
                                      method="POST" 
                                                      class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $asignadas->id }}">
                                    <button type="submit" 
                                                            class="btn btn-modern btn-danger-modern btn-sm"
                                                            onclick="return confirm('¿Estás seguro de eliminar esta categoría del club?')">
                                                        <i class="fas fa-trash-alt me-1"></i>
                                        Eliminar
                                    </button>
                                </form>
                                            </div>
                            @endforeach
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h6>No hay categorías asignadas</h6>
                                        <p class="text-muted">Asigna categorías desde el formulario</p>
                                    </div>
                            @endif
                    </div>
                </div>
            </div>
                    
                    <!-- Formulario de Asignación -->
        <div class="col-md-8">
                        <div class="glass-card">
                            <div class="card-header-modern">
                                <h5 class="mb-0">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Asignar Nueva Categoría
                                </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('clubes.creasignar', ['id' => $clubes->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                                    
                        <div class="mb-4">
                                        <label for="categorias_id" class="form-label-modern">
                                            <i class="fas fa-list me-2"></i>
                                            Seleccionar Categoría
                                        </label>
                                        <select class="form-select form-select-modern" id="categorias_id" name="categorias_id" required>
                                            <option value="" selected disabled>
                                                <i class="fas fa-chevron-down me-2"></i>
                                                Seleccione una categoría...
                                </option>
                                @foreach ($categoria as $catego)
                                                <option value="{{ $catego->id }}">
                                        {{ $catego->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                                    
                        <div class="d-flex justify-content-end gap-3">
                                        <a href="{{ route('clubes.index') }}" class="btn btn-modern btn-danger-modern">
                                            <i class="fas fa-times me-2"></i>
                                Cancelar
                            </a>
                                        <button type="submit" class="btn btn-modern btn-primary-modern">
                                            <i class="fas fa-save me-2"></i>
                                            Guardar Cambios
                            </button>
                        </div>
                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Animación de entrada para las tarjetas
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.glass-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
    
    // Validación del formulario
    document.getElementById('categorias_id').addEventListener('change', function() {
        const submitBtn = document.querySelector('button[type="submit"]');
        if (this.value) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        }
    });
    
    // Confirmación mejorada para eliminación
    document.querySelectorAll('form[action*="deleteasignar"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta categoría del club? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
</script>

@endsection
