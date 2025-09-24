# 🎫 Sistema de Gestión de Carnets para Jugadores

## 📋 Descripción
Sistema completo para la generación y descarga de carnets en formato PDF para jugadores de la Liga de Fútbol Sala, desarrollado con Laravel 8 y la librería `barryvdh/laravel-dompdf`.

## ✨ Características Principales

### 🔐 Control de Acceso
- **Solo administradores** pueden generar y descargar carnets
- Middleware de seguridad integrado
- Validación de permisos en cada solicitud

### 🎨 Diseño del Carnet
- **Diseño profesional** con gradientes y efectos visuales
- **Responsive** y optimizado para impresión
- **Información completa** del jugador:
  - Foto del jugador
  - Datos personales (nombre, cédula, dorsal)
  - Información médica (tipo de sangre, fecha de nacimiento)
  - Datos del club y categoría
  - Información del representante
  - Estado del jugador (activo/inactivo)
  - Código QR único

### 📱 Funcionalidades
- **Vista previa** antes de descargar
- **Descarga directa** en formato PDF
- **Validación de datos** antes de generar
- **Manejo de errores** robusto

## 🚀 Instalación y Configuración

### 1. Dependencias
El sistema ya incluye las dependencias necesarias:
```json
{
    "barryvdh/laravel-dompdf": "^2.2",
    "endroid/qr-code": "^5.0",
    "simplesoftwareio/simple-qrcode": "^4.2"
}
```

### 2. Configuración de DomPDF
La configuración de DomPDF ya está publicada en `config/dompdf.php` con valores optimizados para carnets.

### 3. Rutas Configuradas
```php
// Rutas protegidas por middleware 'admin'
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('jugadores/{id}/carnet', [CarnetController::class, 'generar'])->name('jugadores.carnet');
    Route::get('jugadores/{id}/carnet/preview', [CarnetController::class, 'vistaPrevia'])->name('jugadores.carnet.preview');
});
```

## 📁 Estructura de Archivos

```
app/
├── Http/
│   └── Controllers/
│       └── CarnetController.php          # Controlador principal
├── Http/
│   └── Middleware/
│       └── AdminMiddleware.php           # Middleware de seguridad
resources/
└── views/
    ├── carnet/
    │   ├── template.blade.php           # Template del carnet PDF
    │   └── vista-previa.blade.php       # Vista previa web
    └── jugadores/
        └── index.blade.php              # Lista con botón de carnet
```

## 🎯 Uso del Sistema

### Para Administradores:

1. **Acceder a la lista de jugadores**
   - Ir a `/jugadores`
   - Solo usuarios con `rol_id = 'administrador'` verán el botón "Carnet"

2. **Ver vista previa del carnet**
   - Hacer clic en el botón "Carnet" (verde con ícono de ID)
   - Se abrirá la vista previa en `/admin/jugadores/{id}/carnet/preview`

3. **Descargar el carnet**
   - En la vista previa, hacer clic en "Descargar Carnet PDF"
   - El archivo se descargará automáticamente con el nombre: `carnet_Nombre_Jugador_ID.pdf`

### Validaciones del Sistema:

- ✅ Usuario autenticado
- ✅ Rol de administrador
- ✅ Jugador existe en la base de datos
- ✅ Datos mínimos requeridos (nombre y cédula)
- ✅ Relaciones cargadas (club y categoría)

## 🎨 Personalización del Diseño

### Modificar el Template del Carnet
Editar `resources/views/carnet/template.blade.php`:

```blade
<!-- Cambiar colores del gradiente -->
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

<!-- Modificar información mostrada -->
<div class="info-row">
    <span class="info-label">Campo:</span>
    <span class="info-value">{{ $jugador->campo }}</span>
</div>
```

### Agregar Nuevos Campos
1. Actualizar el modelo `Jugadores` si es necesario
2. Modificar el template en `template.blade.php`
3. Actualizar la vista previa en `vista-previa.blade.php`

## 🔧 Configuración Avanzada

### Optimizar PDFs
En `config/dompdf.php`:
```php
'options' => [
    'dpi' => 150,                    // Mayor calidad
    'enable_font_subsetting' => true, // Reducir tamaño
    'default_paper_size' => 'a4',    // Tamaño estándar
]
```

### Personalizar Nombre de Archivo
En `CarnetController.php`:
```php
$nombreArchivo = 'carnet_' . str_replace(' ', '_', $jugador->nombre) . '_' . $jugador->id . '.pdf';
```

## 🐛 Solución de Problemas

### Error: "No tienes permisos"
- Verificar que el usuario tenga `rol_id = 'administrador'`
- Revisar que el middleware `admin` esté registrado

### Error: "Jugador no encontrado"
- Verificar que el ID del jugador sea válido
- Comprobar que el jugador tenga datos mínimos

### PDF no se genera
- Verificar permisos de escritura en `storage/`
- Comprobar configuración de DomPDF
- Revisar logs en `storage/logs/laravel.log`

### Imágenes no aparecen
- Verificar rutas de imágenes en `public/storage/`
- Comprobar permisos de lectura de archivos
- Usar rutas absolutas para imágenes

## 📊 Casos de Uso

### Caso 1: Generar Carnet Nuevo
1. Administrador accede a lista de jugadores
2. Hace clic en "Carnet" para jugador específico
3. Ve vista previa del carnet
4. Descarga PDF con todos los datos

### Caso 2: Jugador Sin Foto
- El sistema muestra placeholder "Sin Foto"
- El carnet se genera normalmente
- Se incluye advertencia en vista previa

### Caso 3: Datos Incompletos
- Sistema valida datos mínimos requeridos
- Muestra mensaje de error si faltan datos críticos
- Permite generar carnet con datos disponibles

## 🔒 Seguridad

- ✅ Middleware de autenticación
- ✅ Validación de roles
- ✅ Sanitización de datos
- ✅ Protección contra inyección SQL
- ✅ Validación de archivos

## 📈 Rendimiento

- ✅ Carga lazy de relaciones
- ✅ Cache de configuración
- ✅ Optimización de imágenes
- ✅ Compresión de PDFs

## 🚀 Próximas Mejoras

- [ ] Generación masiva de carnets
- [ ] Plantillas personalizables por club
- [ ] Integración con códigos QR reales
- [ ] Historial de carnets generados
- [ ] Notificaciones por email
- [ ] API REST para integraciones

---

## 📞 Soporte

Para soporte técnico o consultas sobre el sistema de carnets, contactar al equipo de desarrollo.

**Versión:** 1.0.0  
**Última actualización:** {{ date('Y-m-d') }}  
**Desarrollado con:** Laravel 8 + DomPDF

