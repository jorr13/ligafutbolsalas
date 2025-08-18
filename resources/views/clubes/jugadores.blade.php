@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card">
        <h1 class="h3 mb-0 text-blue-dark">Jugadores del Club: {{ $club->nombre }}</h1>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="border-0"></th>
                        <th class="border-0">Nombre</th>
                        <th class="border-0">Cédula</th>
                        <th class="border-0">Teléfono</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Numero de Camiseta</th>
                        <th class="border-0">Categoria</th>
                        <th class="border-0">Estado</th>
                        <th class="border-0 text-end actions-column">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jugadores as $jugador)
                    <tr>
                        <td class="fw-medium text-blue-dark"><img src="{{ $jugador->foto_identificacion }}" alt="" width="50" height="50" class="rounded-circle"> </td>
                        <td class="fw-medium text-blue-dark">{{ $jugador->nombre }}</td>
                        <td>{{ $jugador->cedula }}</td>
                        <td>{{ $jugador->telefono }}</td>
                        <td>{{ $jugador->email }}</td>
                        <td>{{ $jugador->numero_dorsal }}</td>
                        <td>{{ $jugador->nombre_categoria ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $jugador->status == 'activo' ? 'success' : 'warning' }}">
                                {{ ucfirst($jugador->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="getJugador({{ $jugador->id }})">
                                    Ver Perfil
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay jugadores disponibles</p>
                        </td>
                    </tr>
                    @endforelse

                
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="spinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center !important;">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getJugador(id){
        $.ajax({
            url: "{{ route('jugadores.infoJugador') }}",
            type: "POST",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            data: { id: id },
            success: function(response) {
                $('#spinner').hide();
                $('#staticBackdropLabel').html('<strong>Jugador: '+response.data.nombre+'</strong>');
                $('.modal-body').html('');
                $('.modal-body').html('<img src="'+response.data.foto_identificacion+'" alt="" width="50" height="50" class="rounded-circle">');
                $('.modal-body').append('<br>Jugador: <strong>'+response.data.nombre+'</strong>');
                $('.modal-body').append('<br>Cédula: <strong>'+response.data.cedula+'</strong>');
                $('.modal-body').append('<br>Teléfono: <strong>'+response.data.telefono+'</strong>');
                $('.modal-body').append('<br>Email: <strong>'+response.data.email+'</strong>');
                $('.modal-body').append('<br>Numero de Camiseta: <strong>'+response.data.numero_dorsal+'</strong>');
                $('.modal-body').append('<br>Categoria: <strong>'+response.data.nombre_categoria+'</strong>');
                $('.modal-body').append('<br>Estado: <strong>'+response.data.status+'</strong>');
            },
            error: function () {
                console.log('mal');
                console.log(datas);
            }
        });
  
    }
</script>
@endsection
