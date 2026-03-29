<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet de Entrenador - {{ $entrenador->nombre }}</title>
    <style>
        @page {
            size: 80mm 50mm landscape;
            margin: 0;
            padding: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        img {
            image-orientation: from-image;
        }
    </style>
</head>
<body>
@php
    $est = $entrenador->estatus ?? 'inactivo';
    $badgeBg = $est === 'activo' ? '#28a745' : ($est === 'sancionado' ? '#ffc107' : '#6c757d');
    $badgeFg = $est === 'sancionado' ? '#212529' : '#ffffff';
@endphp

<table style="width: 80mm; margin: 0; padding: 0; background: #ffffff; border: 0.2mm solid #e9ecef; border-collapse: collapse; table-layout: fixed; page-break-after: always;">
    <tr>
        <td colspan="3" style=" background: #8F0000; color: #ffffff; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 5.5pt; padding: 0.8mm 0; position: relative;">
            <h1 style="display: inline-flex; position: relative; top: 5px; font-size: 10px;">CARNET DE ENTRENADOR</h1>
            <img src="{{ asset('imagen/logoligafutbolsalas.png') }}" alt="Logo" style="display: inline-flex; width: auto; height: 25px; position: relative; top: 5px; left: 15px;">
        </td>
    </tr>
    <tr style=" margin-top: 14px;  position: relative;">
        <td style="width: 20mm; padding: 0.8mm; vertical-align: top; text-align: center;">
            <div style="width: 16mm; height: 22mm; margin-bottom: 0.6mm; margin-top: 12px;">
                @if($entrenador->foto_carnet)
                    @if(isset($imagenesCorregidas['foto']) && $imagenesCorregidas['foto'])
                        <img src="{{ $imagenesCorregidas['foto'] }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @else
                        @php
                            $fotoUrl = str_starts_with($entrenador->foto_carnet, 'entrenadores/')
                                ? asset('storage/' . $entrenador->foto_carnet)
                                : asset('storage/' . $entrenador->foto_carnet);
                        @endphp
                        <img src="{{ $fotoUrl }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @endif
                @else
                    <div style="width: 16mm; height: 18mm; background: #e9ecef; color: #6c757d; font-size: 5pt; line-height: 18mm; text-align: center; position: relative; left: 10px;">Sin Foto</div>
                @endif
            </div>
            <div style="background: {{ $badgeBg }}; color: {{ $badgeFg }}; padding: 0.2mm 0.8mm; font-size: 4.5pt; font-weight: bold; text-transform: uppercase; border-radius: 0.3mm; display: inline-block; margin-top: 5mm;">{{ ucfirst($est) }}</div>
        </td>

        <td style="width: 35mm; padding: 0.8mm; vertical-align: top;">
            <div style="margin-top: 13px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 5.5pt; line-height: 1.1;">
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Nombres:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 5.2pt;">{{ $entrenador->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Cédula:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 5.2pt;">{{ $entrenador->cedula ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Email:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $entrenador->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Teléfono:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 5.2pt;">{{ $entrenador->telefono ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Club:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $entrenador->club->nombre ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </td>

        <td style="width: 25mm; padding: 0.8mm; vertical-align: top; text-align: center;">
            <div style="margin-top: 13px;">
                @if($entrenador->club && $entrenador->club->logo)
                    @if(isset($imagenesCorregidas['logo']) && $imagenesCorregidas['logo'])
                        <img src="{{ $imagenesCorregidas['logo'] }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @else
                        @php
                            $logoClubUrl = str_starts_with($entrenador->club->logo, 'logos/')
                                ? asset('storage/' . $entrenador->club->logo)
                                : asset('storage/' . $entrenador->club->logo);
                        @endphp
                        <img src="{{ $logoClubUrl }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @endif
                    <h5 style="font-size: 5px; font-weight: bold; text-transform: uppercase; color: #212529;">Válido solo para el año {{ date('Y') }}</h5>
                @else
                    <div style="width: 12mm; height: 12mm; background: #f8f9fa; border: 0.2mm solid #e9ecef; color: #6c757d; font-weight: bold; font-size: 5pt; text-align: center; line-height: 12mm; margin: 0 auto 2mm auto;">FS</div>
                    <h5 style="font-size: 5px; font-weight: bold; color: #212529;">Válido {{ date('Y') }}</h5>
                @endif
            </div>
        </td>
    </tr>
</table>

<!-- PÁGINA 2: QR (misma lógica que carnet de jugador) -->
<table style="width: 80mm; margin: 0; padding: 0; background: #ffffff; border: 0.2mm solid #e9ecef; border-collapse: collapse; table-layout: fixed;">
    <tr>
        <td style="width: 40mm; padding: 0.8mm; vertical-align: middle; text-align: center;">
            @if($entrenador->qr_code_image)
                <div style="width: 35mm; height: 35mm; border: 0.2mm solid #e9ecef; background: white; margin: 0 auto; padding: 0.5mm;">
                    <img src="data:image/png;base64,{{ $entrenador->qr_code_image }}" alt="QR" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            @endif
        </td>
        <td style="width: 40mm; padding: 0.8mm; vertical-align: middle; text-align: center;">
            <div style="width: 32mm; height: 35mm; text-align: center; margin: 0 auto;">
                <!-- Espacio para sello (igual que carnet de jugador) -->
            </div>
        </td>
    </tr>
</table>
</body>
</html>
