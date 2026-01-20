<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet de Jugador - {{ $jugador->nombre }}</title>
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

<!-- PÁGINA 1: Información del carnet -->
<table style="width: 80mm; margin: 0; padding: 0; background: #ffffff; border: 0.2mm solid #e9ecef; border-collapse: collapse; table-layout: fixed; page-break-after: always;">
        <!-- Header compacto -->
        <tr>
            <td colspan="3" style=" background: #8F0000; color: #ffffff; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 5.5pt; padding: 0.8mm 0; position: relative;">
             
                <h1 style="  display: inline-flex;position: relative;top: 5px;font-size: 10px;">CARNET DE JUGADOR</h1>
                <img src="{{ asset('imagen/logoligafutbolsalas.png') }}" alt="Logo" style="display: inline-flex; width: auto; height: 25px; position: relative; top: 5px; left: 15px;">
      
            </td>
          
        </tr>
        <!-- Cuerpo principal: 3 columnas para aprovechar mejor el espacio -->
        <tr>
            <!-- Columna izquierda: foto -->
            <td style="width: 20mm; padding: 0.8mm; vertical-align: top; text-align: center;">
                <div style="width: 16mm; height: 18mm; margin-bottom: 0.6mm;">
                    @if($jugador->foto_carnet)
                        @if(isset($imagenesCorregidas['foto']) && $imagenesCorregidas['foto'])
                            <img src="{{ $imagenesCorregidas['foto'] }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px; transform: rotate(0deg);">
                        @else
                            @php
                                $fotoCarnetUrl = str_starts_with($jugador->foto_carnet, 'jugadores/') 
                                    ? asset('storage/' . $jugador->foto_carnet) 
                                    : asset('images/' . $jugador->foto_carnet);
                            @endphp
                            <img src="{{ $fotoCarnetUrl }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px; transform: rotate(0deg); image-orientation: from-image;">
                        @endif
                    @else
                        <div style="width: 16mm; height: 18mm; background: #e9ecef; color: #6c757d; font-size: 5pt; line-height: 18mm; text-align: center; position: relative; left: 10px;">Sin Foto</div>
                    @endif
                </div>
                <!-- Estado -->
                <div style="background: {{ $jugador->status === 'activo' ? '#28a745' : '#ffc107' }}; color: {{ $jugador->status === 'activo' ? '#ffffff' : '#212529' }}; padding: 0.2mm 0.8mm; font-size: 4.5pt; font-weight: bold; text-transform: uppercase; border-radius: 0.3mm; display: inline-block; margin-top: 5mm;">{{ ucfirst($jugador->status ?? 'activo') }}</div>
            </td>
            
            <!-- Columna central: datos principales -->
            <td style="width: 35mm; padding: 0.8mm; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse; font-size: 4.8pt; line-height: 1.1;">
                    <tr>
                        <td style="width: 10mm; color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Apellidos:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->apellidos ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Nombres:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Cédula:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->cedula ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Edad:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->edad ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Categoría:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->categoria->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Nivel:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ ucfirst($jugador->nivel ?? 'iniciante') }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Club:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->club->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Dorsal:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->numero_dorsal ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #495057; font-weight: bold; text-transform: uppercase; padding: 0.15mm 0;">Sangre:</td>
                        <td style="color: #212529; padding: 0.15mm 0; font-size: 4.2pt;">{{ $jugador->tipo_sangre ?? 'N/A' }}</td>
                    </tr>
                </table>
                
                <!-- Representante compacto -->
                {{-- @if($jugador->nombre_representante) 
                <div style="border-top: 0.2mm solid #e9ecef; padding-top: 0.5mm; margin-top: 0.5mm; font-size: 4pt;">
                    <div style="font-weight: bold; color: #495057; text-transform: uppercase;">Representante:</div>
                    <div style="color: #212529;">{{ $jugador->nombre_representante }}</div>
                    @if($jugador->cedula_representante)
                        <div style="color: #212529;">Cédula: {{ $jugador->cedula_representante }}</div>
                    @endif
                    @if($jugador->telefono_representante)
                        <div style="color: #212529;">Tel: {{ $jugador->telefono_representante }}</div>
                    @endif
                </div>
                @endif --}} 
            </td>
            
            <!-- Columna derecha: logo y QR -->
            <td style="width: 25mm; padding: 0.8mm; vertical-align: top; text-align: center;">
                <!-- Logo del club -->
                @if($jugador->club && $jugador->club->logo)
                    @if(isset($imagenesCorregidas['logo']) && $imagenesCorregidas['logo'])
                        <img src="{{ $imagenesCorregidas['logo'] }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @else
                        @php
                            $logoClubUrl = str_starts_with($jugador->club->logo, 'logos/') 
                                ? asset('storage/' . $jugador->club->logo) 
                                : asset('images/' . $jugador->club->logo);
                        @endphp
                        <img src="{{ $logoClubUrl }}" alt="" style="width: 20mm; height: 22mm; object-fit: cover; display: block; position: relative; left: 10px;">
                    @endif
                    <h5 style="font-size: 5px; font-weight: bold; text-transform: uppercase; color: #212529;">Valido solo para el año {{ date('Y') }}</h5>
                @else
                    <div style="width: 12mm; height: 12mm; background: #f8f9fa; border: 0.2mm solid #e9ecef; color: #6c757d; font-weight: bold; font-size: 5pt; text-align: center; line-height: 12mm; margin: 0 auto 2mm auto;">FS</div>
                @endif
                
            </td>

        </tr>
</table>

<!-- PÁGINA 2: QR Code -->
<table style="width: 80mm; margin: 0; padding: 0; background: #ffffff; border: 0.2mm solid #e9ecef; border-collapse: collapse; table-layout: fixed;">
    <tr>
        <td style="width: 40mm; padding: 0.8mm; vertical-align: middle; text-align: center;">
            @if($jugador->qr_code_image)
                <div style="width: 35mm; height: 35mm; border: 0.2mm solid #e9ecef; background: white; margin: 0 auto; padding: 0.5mm;">
                    <img src="data:image/png;base64,{{ $jugador->qr_code_image }}" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            @endif
        </td>
        <td style="width: 40mm; padding: 0.8mm; vertical-align: middle; text-align: center;">
            <div style="width: 32mm; height: 35mm; text-align: center; margin: 0 auto;">
                <!-- Espacio para sello -->
            </div>
        </td>
    </tr>
</table>
</body>
</html>