<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet de Árbitro - {{ $arbitro->nombre }}</title>
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
    $est = $arbitro->estatus ?? 'inactivo';
    $badgeBg = $est === 'activo' ? '#28a745' : ($est === 'sancionado' ? '#ffc107' : '#6c757d');
    $badgeFg = $est === 'sancionado' ? '#212529' : '#ffffff';
@endphp

<table style="width: 80mm; margin: 0; padding: 0; background: #ffffff; border: 0.2mm solid #e9ecef; border-collapse: collapse; table-layout: fixed; page-break-after: always;">
    <tr>
        <td colspan="3" style=" background: #8F0000; color: #ffffff; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 5.5pt; padding: 0.8mm 0; position: relative;">
            <h1 style="display: inline-flex; position: relative; top: 5px; font-size: 10px;">CARNET DE ÁRBITRO</h1>
            <img src="{{ asset('imagen/logoligafutbolsalas.png') }}" alt="Logo" style="display: inline-flex; width: auto; height: 25px; position: relative; top: 5px; left: 15px;">
        </td>
    </tr>
    <tr>
        <td style="width: 20mm; padding: 0.8mm; vertical-align: top; text-align: center;">
            <div style="width: 16mm; height: 22mm; margin-bottom: 0.6mm; margin-top: 12px;">
                @if($arbitro->foto_carnet)
                    @if(isset($imagenesCorregidas['foto']) && $imagenesCorregidas['foto'])
                        <img src="{{ $imagenesCorregidas['foto'] }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @else
                        @php
                            $fotoUrl = asset('storage/' . $arbitro->foto_carnet);
                        @endphp
                        <img src="{{ $fotoUrl }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @endif
                @else
                    <div style="width: 16mm; height: 18mm; background: #e9ecef; color: #6c757d; font-size: 5pt; line-height: 18mm; text-align: center; position: relative; left: 10px;">Sin Foto</div>
                @endif
            </div>
            <div style="background: {{ $badgeBg }}; color: {{ $badgeFg }}; padding: 0.2mm 0.8mm; font-size: 4.5pt; font-weight: bold; text-transform: uppercase; border-radius: 0.3mm; display: inline-block; margin-top: 5mm;">{{ ucfirst($est) }}</div>
        </td>

        <td style="width: 38mm; padding: 0.8mm; vertical-align: top;">
            <div style="margin-top: 13px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 5.5pt; line-height: 1.1;">
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Nombres:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 5.2pt;">{{ $arbitro->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Cédula:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 5.2pt;">{{ $arbitro->cedula ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Email:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $arbitro->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Teléfono:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 5.2pt;">{{ $arbitro->telefono ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="color: #495057; font-size: 4.5pt; padding-top: 1mm;">Oficial de la Liga Fútbol Sala de Caracas</td>
                    </tr>
                </table>
            </div>
        </td>

        <td style="width: 22mm; padding: 0.8mm; vertical-align: middle; text-align: center;">
            <div style="margin-top: 8px;">
                <img src="{{ asset('imagen/logoligafutbolsalas.png') }}" alt="" style="width: 18mm; height: auto;">
                <h5 style="font-size: 5px; font-weight: bold; text-transform: uppercase; color: #212529; margin-top: 2mm;">Válido {{ date('Y') }}</h5>
            </div>
        </td>
    </tr>
</table>

<table style="width: 80mm; margin: 0; padding: 0; background: #ffffff; border: 0.2mm solid #e9ecef; border-collapse: collapse; table-layout: fixed;">
    <tr>
        <td style="padding: 2mm; vertical-align: middle; text-align: center;">
            <div style="font-size: 6pt; color: #8F0000; font-weight: bold;">ÁRBITRO AUTORIZADO</div>
            <div style="font-size: 5pt; color: #495057; margin-top: 1mm;">Documento de identificación para actividades oficiales de la liga.</div>
        </td>
    </tr>
</table>
</body>
</html>
