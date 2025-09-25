<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet de Jugador - {{ $jugador->nombre }}</title>
</head>
<body>
    
    <!-- Contenedor principal del carnet -->
    <table style="width: 400px; height: 250px; margin: 0 auto; background: #ffffff; border: 2px solid #e9ecef; border-collapse: collapse;">
        
        <!-- Header del carnet -->
        <tr>
            <td colspan="3" style="background: #007bff; padding: 12px 20px; text-align: center; color: white; font-weight: bold; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; position: relative; height: 50px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center; font-size: 16px; font-weight: bold;">
                            CARNET DE JUGADOR
                        </td>
                        <td style="text-align: right; width: 50px;">
                
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <!-- Contenido principal -->
        <tr>
            <td style="padding: 15px; vertical-align: top; width: 120px;">
                <!-- Sección de foto -->
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center;">
                            <div style="width: 100px; height: 120px; border: 2px solid #e9ecef; background: #f8f9fa; text-align: center; vertical-align: middle;">
                                @if($jugador->foto_carnet)
                                    <img src="{{ $jugador->foto_carnet ? asset('images/' . $jugador->foto_carnet) : '/images/default-avatar.png' }}" 
                                         alt="Foto del jugador" style="width: 100px; height: 120px; object-fit: cover;">
                                @else
                                    <div style="width: 100px; height: 120px; background: #e9ecef; color: #6c757d; font-size: 12px; text-align: center; vertical-align: middle; line-height: 120px;">
                                        Sin Foto
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            
            <td style="padding: 15px; vertical-align: top;">
                <!-- Sección de información -->
                <table style="width: 100%; font-size: 11px;">
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef; width: 80px;">Apellidos:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->apellidos ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">Nombres:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->nombre ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">Cédula:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->cedula ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">Edad:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->edad ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">Categoría:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->categoria->nombre ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">Club:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->club->nombre ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">Dorsal:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0; border-bottom: 1px dotted #e9ecef;">{{ $jugador->numero_dorsal ?? 'N/A' }}</td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0;">Tipo Sangre:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0;">{{ $jugador->tipo_sangre ?? 'N/A' }}</td>
                    </tr>
                    
                </table>
            </td>
            
            <td style="padding: 15px; vertical-align: top; width: 80px; text-align: center;">
                <!-- Badge de estado -->
                <div style="background: {{ $jugador->status === 'activo' ? '#28a745' : '#ffc107' }}; color: {{ $jugador->status === 'activo' ? 'white' : '#212529' }}; padding: 4px 8px; font-size: 9px; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">
                    {{ ucfirst($jugador->status ?? 'activo') }}
                </div>
                
                <!-- Sección QR -->
                <div style="width: 50px; height: 50px; background: #f8f9fa; border: 1px solid #e9ecef; text-align: center; vertical-align: middle; font-size: 8px; color: #6c757d; font-weight: bold;">
                    @if($jugador->club && $jugador->club->logo)
                        <img src="{{ public_path('storage/' . $jugador->club->logo) }}" 
                                alt="Logo" style="width: 25px; height: 25px; border-radius: 50%;">
                    @else
                        <div style="width: 25px; height: 25px; background: rgba(255,255,255,0.3); border-radius: 50%; text-align: center; line-height: 25px; font-size: 10px; font-weight: bold;">FS</div>
                    @endif
                </div>
            </td>
        </tr>
        
        <!-- Información del representante -->
        @if($jugador->nombre_representante)
        <tr>
            <td colspan="3" style="padding: 10px 15px; border-top: 2px solid #e9ecef;">
                <table style="width: 100%; font-size: 10px;">
                    <tr>
                        <td colspan="2" style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0;">Representante Legal</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0; width: 80px;">Nombre:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0;">{{ $jugador->nombre_representante }}</td>
                    </tr>
                    @if($jugador->cedula_representante)
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0;">Cédula:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0;">{{ $jugador->cedula_representante }}</td>
                    </tr>
                    @endif
                    @if($jugador->telefono_representante)
                    <tr>
                        <td style="font-weight: bold; color: #495057; text-transform: uppercase; padding: 2px 0;">Teléfono:</td>
                        <td style="color: #212529; font-weight: 500; padding: 2px 0;">{{ $jugador->telefono_representante }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
        @endif
        
    </table>

    <!-- Observaciones -->
    @if($jugador->observacion)
    <table style="width: 400px; margin: 15px auto 0;">
        <tr>
            <td style="padding: 10px; background: #f8f9fa; border-left: 4px solid #007bff;">
                <div style="font-size: 10px; font-weight: bold; color: #495057; margin-bottom: 3px;">Observaciones:</div>
                <div style="font-size: 11px; color: #6c757d; line-height: 1.3;">{{ $jugador->observacion }}</div>
            </td>
        </tr>
    </table>
    @endif
    
</body>
</html>

