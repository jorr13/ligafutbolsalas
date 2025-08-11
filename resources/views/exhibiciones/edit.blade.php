@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ env('URL_PATH') }}{{ $exhibicion->logo }}" 
                         alt="Logo {{ $exhibicion->title }}" 
                         class="img-fluid mb-3">
                    <div class="mb-3">
                        <h6 class="text-blue-dark mb-2">URL asignada:</h6>
                        <a href="{{ $exhibicion->url }}" class="text-break">{{ $exhibicion->url }}</a>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-blue-dark mb-2">Código QR:</h6>
                        <img src="data:image/png;base64,{{ $exhibicion->qr }}" 
                             alt="QR Code" 
                             class="img-fluid"
                             style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Editar Exhibición: {{ $exhibicion->title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('exhibiciones.update', ['exhibicione' => $exhibicion->id]) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Título</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   required 
                                   value="{{ $exhibicion->title }}">
                        </div>
                        <div class="mb-4">
                            <label for="logo" class="form-label text-blue-dark">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                            <small class="text-muted">Si no desea modificar el logo deje este campo vacío</small>
                        </div>
                        <div class="mb-4">
                            <label for="estatus" class="form-label text-blue-dark">Estatus</label>
                            <select class="form-select" id="estatus" name="estatus" required>
                                <option value="0" @if($exhibicion->estatus=="0") selected @endif>Inactivo</option>
                                <option value="1" @if($exhibicion->estatus=="1") selected @endif>Activo</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('exhibiciones.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    $("#type").change(function(){
        if($(this).val() == "1"){
            $("#elpapahidden").show();
        }else{
            $("#elpapahidden").hide();
        }
      
    });
</script> --}}
@endsection
