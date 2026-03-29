<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenador — {{ $entrenador->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: Arial, sans-serif;
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
            background: linear-gradient(135deg, #8F0000, #5a0000);
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
        }
        .player-info { padding: 30px; }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label { font-weight: bold; color: #495057; text-transform: uppercase; font-size: 0.9em; }
        .info-value { color: #212529; font-size: 1.05em; }
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
            <div class="player-header">
                <h1 class="mb-3 h4">CARNET DE ENTRENADOR</h1>
                @if($entrenador->foto_carnet)
                    <img src="{{ asset('storage/' . $entrenador->foto_carnet) }}" alt="" class="player-photo">
                @else
                    <div class="player-photo d-inline-flex align-items-center justify-content-center bg-light text-muted mx-auto">Sin foto</div>
                @endif
                <h2 class="mt-3 mb-2 h4">{{ $entrenador->nombre }}</h2>
                <span class="badge {{ $entrenador->estatus === 'activo' ? 'bg-success' : ($entrenador->estatus === 'sancionado' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                    {{ ucfirst($entrenador->estatus ?? '') }}
                </span>
            </div>

            <div class="player-info">
                <div class="info-row">
                    <span class="info-label">Cédula</span>
                    <span class="info-value">{{ $entrenador->cedula ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Club</span>
                    <span class="info-value">{{ $entrenador->club->nombre ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Teléfono</span>
                    <span class="info-value">{{ $entrenador->telefono ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value text-break">{{ $entrenador->email ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="qr-section">
                <h6 class="text-muted mb-3">Escanea este código QR para acceder a esta información</h6>
                @if($entrenador->qr_code_image)
                    <div class="qr-code">
                        <img src="data:image/png;base64,{{ $entrenador->qr_code_image }}" alt="QR" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
