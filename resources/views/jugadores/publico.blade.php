<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Jugador - {{ $jugador->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .player-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            margin: 20px auto;
            max-width: 600px;
        }
        .player-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .player-photo {
            width: 120px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .player-info {
            padding: 30px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        .info-value {
            color: #212529;
            font-size: 1.1em;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8em;
        }
        .status-activo {
            background: #28a745;
            color: white;
        }
        .status-pendiente {
            background: #ffc107;
            color: #212529;
        }
        .club-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }
        .qr-section {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="player-card">
            <!-- Header -->
            <div class="player-header">
                <h1 class="mb-3">CARNET DE JUGADOR</h1>
                @if($jugador->foto_carnet)
                    <img src="{{ asset('images/' . $jugador->foto_carnet) }}" alt="Foto del jugador" class="player-photo">
                @else
                    <div class="player-photo d-flex align-items-center justify-content-center bg-light text-muted">
                        Sin Foto
                    </div>
                @endif
                <h2 class="mt-3 mb-2">{{ $jugador->nombre }} {{ $jugador->apellidos }}</h2>
                <div class="status-badge {{ $jugador->status === 'activo' ? 'status-activo' : 'status-pendiente' }}">
                    {{ ucfirst($jugador->status) }}
                </div>
            </div>

            <!-- Información del jugador -->
            <div class="player-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">Cédula:</span>
                            <span class="info-value">{{ $jugador->cedula ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Edad:</span>
                            <span class="info-value">{{ $jugador->edad ?? 'N/A' }} años</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Categoría:</span>
                            <span class="info-value">{{ $jugador->categoria->nombre ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nivel:</span>
                            <span class="info-value">{{ ucfirst($jugador->nivel ?? 'iniciante') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dorsal:</span>
                            <span class="info-value">{{ $jugador->numero_dorsal ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">Club:</span>
                            <span class="info-value">{{ $jugador->club->nombre ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tipo de Sangre:</span>
                            <span class="info-value">{{ $jugador->tipo_sangre ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Teléfono:</span>
                            <span class="info-value">{{ $jugador->telefono ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $jugador->email ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dirección:</span>
                            <span class="info-value">{{ $jugador->direccion ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Información del representante -->
                @if($jugador->nombre_representante)
                <div class="mt-4">
                    <h5 class="text-primary mb-3">Representante Legal</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label">Nombre:</span>
                                <span class="info-value">{{ $jugador->nombre_representante }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label">Cédula:</span>
                                <span class="info-value">{{ $jugador->cedula_representante ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    @if($jugador->telefono_representante)
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value">{{ $jugador->telefono_representante }}</span>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Observaciones -->
                @if($jugador->observacion)
                <div class="mt-4">
                    <h5 class="text-primary mb-3">Observaciones</h5>
                    <div class="alert alert-info">
                        {{ $jugador->observacion }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sección QR -->
            <div class="qr-section">
                <h6 class="text-muted mb-3">Escanea este código QR para acceder a esta información</h6>
                @if($jugador->qr_code_image)
                    <div class="qr-code">
                        <img src="data:image/png;base64,{{ $jugador->qr_code_image }}" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


