# 💰 Sistema de Control de Pagos de Jugadores

## 📋 Descripción
Sistema para gestionar y controlar los pagos de jugadores en la Liga de Fútbol Sala. Permite a los administradores marcar qué jugadores han realizado sus pagos correspondientes, con indicadores visuales distintivos.

## ✨ Características Principales

### 🔐 Control de Acceso
- **Solo administradores** pueden marcar/desmarcar pagos
- Los indicadores de pago son **visibles únicamente para administradores**
- Entrenadores y otros usuarios no ven esta información

### 🎨 Indicadores Visuales
- **Badge en la foto del jugador**: 
  - 🔴 Rojo con símbolo de exclamación: Pago pendiente
  - 🟢 Verde con símbolo de dólar: Pago realizado
- **Botón de acción**:
  - Rojo "Pagar": Para marcar como pagado
  - Verde "Pagado": Para marcar como no pagado
- Animaciones suaves al cambiar estados
- Tooltips informativos en hover

### 📱 Funcionalidades
- **Toggle rápido**: Un clic para cambiar el estado de pago
- **Confirmación de acción**: Mensaje de confirmación antes de cambiar estado
- **Actualización en tiempo real**: Sin recargar la página (AJAX)
- **Feedback visual inmediato**: Los cambios se reflejan instantáneamente
- **Disponible en dos módulos**:
  - Lista principal de jugadores (`/jugadores`)
  - Lista de jugadores pendientes (`/jugadores-pendientes`)

## 🚀 Estructura Implementada

### 1. Base de Datos
**Migración**: `2026_02_01_000001_add_pago_to_jugadores_table.php`
```php
// Campo agregado a la tabla jugadores
$table->tinyInteger('pago')->default(0)->after('status')->comment('0=no pagó, 1=pagó');
```

**Valores**:
- `0`: Jugador no ha pagado (por defecto)
- `1`: Jugador ha pagado

### 2. Modelo
**Archivo**: `app/Models/Jugadores.php`
- Campo `pago` agregado al array `$fillable`

### 3. Controlador
**Archivo**: `app/Http/Controllers/JugadoresController.php`

**Método agregado**: `togglePago($id)`
- Valida permisos de administrador
- Alterna el estado de pago (0 ↔ 1)
- Retorna respuesta JSON con el nuevo estado

### 4. Rutas
**Archivo**: `routes/web.php`
```php
// Dentro del grupo admin->middleware('admin')
Route::post('jugadores/{id}/toggle-pago', [JugadoresController::class, 'togglePago'])
    ->name('admin.jugadores.togglePago');
```

### 5. Vista
**Archivo**: `resources/views/jugadores/index.blade.php`

**Elementos agregados**:
- Estilos CSS para badges de pago
- Badge visual en la foto del jugador
- Botón de acción en la columna de acciones
- Función JavaScript `togglePago()` para manejar el cambio de estado

## 🎯 Uso del Sistema

### Para Administradores:

1. **Ver estado de pago**
   - Al listar jugadores, verás un badge en la esquina superior derecha de su foto
   - 🔴 Rojo = No ha pagado
   - 🟢 Verde = Ha pagado

2. **Marcar como pagado**
   - Buscar al jugador en la lista
   - Hacer clic en el botón rojo "Pagar" en las acciones
   - Confirmar la acción
   - El badge y botón cambian a verde automáticamente

3. **Marcar como no pagado**
   - Buscar al jugador con pago marcado (badge verde)
   - Hacer clic en el botón verde "Pagado"
   - Confirmar la acción
   - El badge y botón cambian a rojo automáticamente

### Ubicaciones donde marcar pago:
- `/jugadores` - Lista principal de todos los jugadores
- `/jugadores-pendientes` - Lista de jugadores pendientes de aprobación

## 🔧 Detalles Técnicos

### Estilos CSS Principales
```css
.pago-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    /* ... más estilos ... */
}

.pago-badge.pagado {
    background-color: #28a745; /* Verde */
    color: white;
}

.pago-badge.no-pagado {
    background-color: #dc3545; /* Rojo */
    color: white;
}
```

### Función JavaScript
```javascript
function togglePago(jugadorId) {
    // Confirmación
    // Petición AJAX al servidor
    // Actualización visual del badge y botón
    // Feedback al usuario
}
```

### Endpoint API
- **URL**: `POST /admin/jugadores/{id}/toggle-pago`
- **Middleware**: `auth`, `admin`
- **Respuesta exitosa**:
```json
{
    "message": "Pago marcado como realizado",
    "pago": 1,
    "code": 200,
    "type": "success"
}
```

## 🔒 Seguridad

- ✅ Validación de rol de administrador en el backend
- ✅ Middleware `admin` protege la ruta
- ✅ Token CSRF en peticiones AJAX
- ✅ Indicadores solo visibles para administradores
- ✅ Validación de permisos en el controlador

## 📊 Casos de Uso

### Caso 1: Marcar Jugador como Pagado
1. Administrador entra a `/jugadores`
2. Ve jugador con badge rojo (no pagado)
3. Hace clic en botón "Pagar"
4. Confirma la acción
5. Sistema actualiza estado y muestra badge verde

### Caso 2: Corregir Pago Marcado por Error
1. Administrador identifica jugador marcado como pagado por error
2. Hace clic en botón "Pagado" (verde)
3. Confirma que desea marcarlo como no pagado
4. Sistema actualiza estado y muestra badge rojo

### Caso 3: Vista de Entrenador
1. Entrenador entra a `/jugadores`
2. No ve ningún badge de pago en las fotos
3. No ve botones de marcar pago
4. Solo administradores tienen acceso a esta funcionalidad

## 🐛 Solución de Problemas

### Error: "No tienes permisos"
- Verificar que el usuario tenga `rol_id = 'administrador'`
- Revisar que el middleware `admin` esté activo

### Badge no aparece
- Verificar que el usuario sea administrador
- Revisar que el campo `pago` exista en la base de datos
- Ejecutar `php artisan migrate` si no se ejecutó

### Botón no actualiza el estado
- Verificar que jQuery esté cargado
- Comprobar la consola del navegador por errores
- Verificar que la ruta `admin.jugadores.togglePago` esté registrada
- Verificar el token CSRF

### Estado no persiste
- Verificar que el campo `pago` esté en el array `fillable` del modelo
- Comprobar permisos de escritura en la base de datos
- Revisar logs en `storage/logs/laravel.log`

## 📈 Mejoras Futuras

- [ ] Historial de pagos (fecha de pago, monto, concepto)
- [ ] Notificaciones automáticas de pagos pendientes
- [ ] Reporte de jugadores sin pagar
- [ ] Exportación de lista de pagos
- [ ] Integración con pasarelas de pago
- [ ] Recordatorios automáticos por email/SMS
- [ ] Dashboard con estadísticas de pagos

---

## 📞 Notas de Implementación

**Versión:** 1.0.0  
**Fecha:** 2026-02-01  
**Desarrollado con:** Laravel 8 + Ajax (jQuery)

### Comandos ejecutados:
```bash
php artisan migrate  # Para crear el campo pago en la tabla jugadores
```

### Archivos modificados:
- `database/migrations/2026_02_01_000001_add_pago_to_jugadores_table.php` (nuevo)
- `app/Models/Jugadores.php`
- `app/Http/Controllers/JugadoresController.php`
- `routes/web.php`
- `resources/views/jugadores/index.blade.php`
