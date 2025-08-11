@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-gradient-white">
                    <h5 class="mb-0 text-blue-dark">Nueva Exhibición</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('exhibiciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label text-blue-dark">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-4">
                            <label for="logo" class="form-label text-blue-dark">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('exhibiciones.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#type").change(function(){
        if($(this).val() == "1"){
            $("#elpapahidden").show();
        }else{
            $("#elpapahidden").hide();
        }
      
    });
</script>
@endsection
