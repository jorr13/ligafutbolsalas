# Liga Fútbol Sala - Sistema de Gestión Integral

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.75-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.0-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/Bootstrap-5.1.3-purple.svg" alt="Bootstrap Version">
  <img src="https://img.shields.io/badge/Vue.js-2.6.12-green.svg" alt="Vue.js Version">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange.svg" alt="MySQL Version">
</p>

<p align="center">
  <b>Sistema completo de gestión para ligas de fútbol sala</b>
</p>

---

## 📋 Descripción del Proyecto

**Liga Fútbol Sala** es un sistema de gestión integral desarrollado en Laravel 8 para administrar clubes, jugadores, entrenadores, árbitros, categorías y exhibiciones de fútbol sala. El sistema proporciona una plataforma completa para la gestión administrativa de una liga deportiva con funcionalidades avanzadas como generación de carnets, códigos QR, historial de movimientos y transferencias entre clubes.

### 🎯 Objetivo Principal

Facilitar la gestión administrativa de una liga de fútbol sala, permitiendo el registro, seguimiento y control de todos los actores involucrados (jugadores, entrenadores, árbitros, clubes), con un enfoque en la trazabilidad de movimientos y la documentación oficial.

---

## ✨ Características Principales

### 👥 Gestión de Usuarios y Roles
- **Administrador**: Control total del sistema, aprobación de jugadores, generación de carnets, transferencias
- **Entrenador**: Gestión de jugadores de su club, registro de datos, asignación de categorías
- **Árbitro**: Registro y gestión de su información personal
- Sistema de autenticación seguro con Laravel UI
- Perfiles personalizados con edición de documentos

### 🏢 Gestión de Clubes
- ✅ CRUD completo de clubes
- 🖼️ Gestión de logos con almacenamiento en `public/storage/logos/`
- 👥 Asignación de entrenadores a clubes
- 📊 Sistema de historial completo con trazabilidad
- 🏷️ Asignación de múltiples categorías por club
- 📋 Visualización de jugadores por club
- 📈 Estadísticas y conteos automáticos

### ⚽ Gestión de Jugadores
- ✅ Registro completo con validación de datos
- 📸 Sistema de fotos (carnet, cédula, identificación) con almacenamiento centralizado
- 👨‍👩‍👧‍👦 Información de representantes legales (padres/tutores)
- 🔄 Sistema de aprobación de jugadores (pendiente → activo)
- 🎯 Asignación a categorías por edad/nivel
- 🏷️ Numeración de dorsales
- 🏥 Datos médicos (tipo de sangre, fecha nacimiento)
- 📋 Estados: "pendiente" y "activo"
- 📊 Notificaciones de jugadores pendientes para administradores
- 🔍 Búsqueda y filtrado avanzado

### 🎫 Sistema de Carnets
- 🖨️ Generación automática de carnets en PDF
- 📱 Códigos QR únicos por jugador
- 🎨 Diseño profesional y optimizado para impresión
- 👁️ Vista previa antes de descarga
- 🔒 Control de acceso exclusivo para administradores
- 📄 Información completa del jugador en formato tarjeta
- Ver documentación completa: `CARNET_SYSTEM_README.md`

### 🏆 Gestión de Categorías
- ✅ CRUD de categorías por edad/nivel
- 🏷️ Asignación múltiple de categorías a clubes
- 📊 Gestión de estados activo/inactivo
- 🔗 Sistema de relaciones muchos a muchos

### 👨‍💼 Gestión de Entrenadores
- ✅ Registro completo con documentación
- 📸 Fotos de carnet y cédula
- 📄 Almacenamiento de CV
- 🏢 Asignación a clubes
- 📝 Edición de perfil personal
- 🔐 Sistema de autenticación

### ⚖️ Gestión de Árbitros
- ✅ Registro completo con documentación
- 📸 Fotos de carnet y cédula
- 📄 Almacenamiento de CV
- 🔐 Sistema de autenticación
- 📝 Edición de perfil personal

### 📦 Sistema de Transferencias
- 🔄 Transferencia de jugadores entre clubes
- 📝 Registro automático en historial
- 📊 Trazabilidad completa de movimientos
- 🔍 Historial detallado por jugador
- ⏱️ Fechas y razones de transferencia

### 📊 Sistema de Historial
- 📝 Historial completo de jugadores (cambios de club, transferencias)
- 📋 Historial de clubes (asignación de categorías, entrenadores, jugadores)
- 📈 Exportación de reportes
- 🔍 API para consultas programáticas
- 📅 Visualización temporal de eventos

### 🎨 Interfaz de Usuario
- 📱 **Completamente responsive** con Bootstrap 5
- 🎨 **Diseño moderno** con gradientes y efectos visuales
- ⚡ **AJAX** para mejor rendimiento
- 🔔 **Notificaciones** de éxito/error
- 🎯 **Modales** para información detallada
- 🖼️ **Gestión de imágenes** optimizada
- 🌐 **Multi-idioma** (preparado para español)

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Framework**: Laravel 8.75
- **PHP**: 7.3 o 8.0+
- **Base de datos**: MySQL 8.0
- **Autenticación**: Laravel UI (Breeze base)
- **PDFs**: DomPDF 2.2
- **QR Codes**: Endroid QR Code 5.0 + Simple QR Code 4.2

### Frontend
- **CSS Framework**: Bootstrap 5.1.3
- **JavaScript**: Vue.js 2.6.12
- **HTTP Client**: Axios
- **Build Tool**: Laravel Mix 6.0.6
- **Preprocessor**: Sass
- **Iconos**: Font Awesome (incluido)

### Almacenamiento de Archivos
- **Sistema de discos**: Laravel Filesystem con configuración personalizada
- **Ubicación**: `public/storage/` con subdirectorios:
  - `logos/` - Logos de clubes
  - `jugadores/` - Fotos y documentos de jugadores
  - `entrenadores/` - Fotos y documentos de entrenadores
  - `arbitros/` - Fotos y documentos de árbitros
  - `qrs/` - Códigos QR generados

---

## 📁 Estructura del Proyecto

### Modelos Eloquent
```
app/Models/
├── User.php                    # Usuarios del sistema
├── Clubes.php                  # Modelo principal de clubes
├── Jugadores.php               # Modelo principal de jugadores
├── Categorias.php              # Categorías por edad/nivel
├── ClubesCategorias.php        # Tabla pivot clubes-categorías
├── Entrenadores.php            # Modelo de entrenadores
├── Arbitros.php                # Modelo de árbitros
├── HistorialJugador.php        # Historial de jugadores
└── HistorialClub.php           # Historial de clubes
```

### Controladores
```
app/Http/Controllers/
├── ClubController.php          # Gestión de clubes
├── JugadoresController.php     # Gestión de jugadores
├── EntrenadoresController.php  # Gestión de entrenadores
├── ArbitrosController.php      # Gestión de árbitros
├── CategoriasController.php    # Gestión de categorías
├── CarnetController.php        # Generación de carnets
├── TransferenciaController.php # Sistema de transferencias
├── HistorialClubController.php # Historial de clubes
├── PerfilController.php        # Perfiles de usuarios
├── UsuarioController.php       # Gestión de usuarios
└── HomeController.php          # Dashboard principal
```

### Migraciones
```
database/migrations/
├── 2025_05_11_203654_clubes_migracion.php
├── 2025_05_11_203718_categorias_migracion.php
├── 2025_05_11_203817_clubes_categorias_migracion.php
├── 2025_05_11_204231_jugadores_migracion.php
├── 2025_05_11_204255_entrenadores_migracion.php
├── 2025_09_15_020656_create_historial_jugadores_table.php
├── 2025_09_18_013458_create_historial_clubes_table.php
├── 2025_09_28_221457_add_nivel_to_jugadores_table.php
├── 2025_10_06_033437_add_qr_fields_to_jugadores_table.php
└── 2025_10_15_010457_create_arbitros_table.php
```

---

## 🚀 Instalación y Configuración

### Requisitos Previos
- ✅ PHP 7.3 o 8.0+
- ✅ Composer 2.x
- ✅ MySQL 8.0+
- ✅ Node.js 14+ y NPM
- ✅ Extensión PHP: GD, Zip, XML, SimpleXML

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone [URL_DEL_REPOSITORIO]
cd ligafutbolsala
```

2. **Instalar dependencias de PHP**
```bash
composer install
```

3. **Instalar dependencias de Node.js**
```bash
npm install
```

4. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar base de datos en `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ligafutbolsala
DB_USERNAME=root
DB_PASSWORD=
```

6. **Importar base de datos**
```bash
# Opción 1: Importar SQL directamente
mysql -u root -p ligafutbolsala < ligadefutbolsalas.sql

# Opción 2: Ejecutar migraciones
php artisan migrate
```

7. **Crear storage link**
```bash
php artisan storage:link
```

8. **Compilar assets**
```bash
# Desarrollo
npm run dev

# Producción
npm run production
```

9. **Limpiar caches**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

10. **Iniciar servidor**
```bash
php artisan serve
```

Acceder a: `http://localhost:8000`

### Credenciales de Acceso (Datos de Prueba)
- **Administrador**: jerinson@yopmail.com / [verificar contraseña en DB]
- **Entrenador**: entrenadorjjjje@yopmail.com / [verificar contraseña en DB]

---

## 🎯 Funcionalidades Destacadas

### 🔄 Sistema de Aprobación de Jugadores
- Los entrenadores registran jugadores → estado "pendiente"
- Los administradores revisan y aprueban → estado "activo"
- Notificaciones visibles en dashboard
- Contador de jugadores pendientes

### 📁 Gestión de Archivos Optimizada
- Sistema de almacenamiento centralizado en `public/storage/`
- Compatibilidad con archivos antiguos y nuevos
- Validación de tipos y tamaños de archivo
- Eliminación automática de archivos antiguos al actualizar
- Previsualización de archivos existentes

### 🎫 Sistema de Carnets Profesional
- Generación de carnets en PDF de alta calidad
- Códigos QR únicos por jugador
- Vista previa web antes de descarga
- Información completa e impresiones profesionales
- Control de acceso exclusivo para administradores
- Ver: `CARNET_SYSTEM_README.md`

### 🔍 Búsqueda y Filtrado Avanzado
- Filtros por categoría, club, estado
- Búsqueda por nombre, cédula, dorsal
- Paginación automática
- Resultados en tiempo real

### 📊 Dashboard Inteligente
- Estadísticas por club
- Contador de jugadores activos/pendientes
- Accesos rápidos a funciones principales
- Cards informativos con datos relevantes

### 🔐 Seguridad Implementada
- Autenticación con Laravel UI
- Middleware de roles y permisos
- Protección CSRF
- Validación de formularios
- Sanitización de datos
- Protección contra inyección SQL
- Segregación de archivos por usuario

---

## 🌐 Rutas Principales

### Rutas Protegidas (requieren autenticación)
```php
/jugadores                # Gestión de jugadores
/clubes                   # Gestión de clubes
/categorias               # Gestión de categorías
/entrenadores             # Gestión de entrenadores
/arbitros                 # Gestión de árbitros
/usuarios                 # Gestión de usuarios
/perfil                   # Perfil del usuario
```

### Rutas para Administradores
```php
/jugadores-pendientes      # Jugadores pendientes de aprobación
/admin/jugadores/{id}/transferir    # Transferir jugador
/admin/jugadores/{id}/carnet       # Generar carnet
/admin/jugadores/{id}/historial    # Historial de jugador
/clubes/{id}/historial    # Historial de club
```

### Rutas para Entrenadores
```php
/jugadores              # Mis jugadores
/ver-clubes               # Ver otros clubes
/ver-clubes/{id}/jugadores # Ver jugadores de otro club
```

### Rutas Públicas
```php
/jugador/{id}             # Vista pública de jugador (por QR)
```

---

## 📊 Base de Datos

### Tablas Principales
- `users` - Usuarios del sistema
- `clubes` - Clubes de fútbol sala
- `categorias` - Categorías por edad/nivel
- `clubes_categorias` - Tabla pivot
- `jugadores` - Registro de jugadores
- `entrenadores` - Registro de entrenadores
- `arbitros` - Registro de árbitros
- `historial_jugadores` - Historial de movimientos de jugadores
- `historial_clubes` - Historial de eventos de clubes

### Relaciones Eloquent
- Clubes ↔ Categorías (Muchos a Muchos)
- Clubes ↔ Entrenadores (Uno a Muchos)
- Clubes ↔ Jugadores (Uno a Muchos)
- Jugadores ↔ Categorías (Muchos a Uno)
- Jugadores ↔ Entrenadores (Muchos a Uno)

---

## 🎨 Personalización

### Modificar Almacenamiento
El sistema usa disco `storage` personalizado en `config/filesystems.php`:
```php
'storage' => [
    'driver' => 'local',
    'root' => public_path('storage'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
]
```

### Personalizar Templates
- Carnet: `resources/views/carnet/template.blade.php`
- Layouts: `resources/views/layouts/app.blade.php`
- Estilos: `resources/sass/app.scss`

---

## 🐛 Solución de Problemas

### Errores Comunes

**Error de Storage**
```bash
php artisan storage:link
php artisan config:clear
```

**Permisos de Archivos**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Cache de Vistas**
```bash
php artisan view:clear
php artisan cache:clear
```

**QR Codes no se generan**
- Verificar instalación de `simplesoftwareio/simple-qrcode`
- Comprobar permisos de escritura en `public/storage/qrs/`

---

## 📈 Roadmap / Próximas Mejoras

- [ ] Generación masiva de carnets
- [ ] Plantillas personalizables por club
- [ ] Sistema de notificaciones por email
- [ ] Integración con APIs externas
- [ ] App móvil nativa
- [ ] Sistema de estadísticas avanzadas
- [ ] Gestión de partidos y resultados
- [ ] Calendario de eventos
- [ ] Chat entre usuarios
- [ ] Multi-idioma completo

---

## 🤝 Contribución

Las contribuciones son bienvenidas. Para cambios importantes:

1. Fork el proyecto
2. Crea tu rama (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 👨‍💻 Autor

**Jerinson** - Desarrollador Full Stack  
Sistema de Gestión de Liga de Fútbol Sala

---

## 📞 Soporte

Para soporte técnico o consultas:
- 📧 Email: [email_contacto]
- 📖 Documentación: Ver archivos README en el proyecto
- 🐛 Issues: [URL_repositorio]/issues

---

<p align="center">
  <b>Desarrollado con ❤️ usando Laravel 8</b><br>
  Sistema de Gestión Integral para Ligas Deportivas
</p>
