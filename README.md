# Liga Fútbol Sala - Sistema de Gestión

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.75-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.0-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/Bootstrap-5.1.3-purple.svg" alt="Bootstrap Version">
  <img src="https://img.shields.io/badge/Vue.js-2.6.12-green.svg" alt="Vue.js Version">
</p>

## 📋 Descripción del Proyecto

**Liga Fútbol Sala** es un sistema de gestión integral desarrollado en Laravel 8 para administrar clubes, jugadores, entrenadores, categorías y exhibiciones de fútbol sala. El sistema proporciona una plataforma completa para la gestión administrativa de una liga deportiva.

## 🚀 Características Principales

### 👥 Gestión de Usuarios y Roles
- **Administrador**: Acceso completo al sistema
- **Entrenador**: Gestión de jugadores de su club
- Sistema de autenticación seguro con Laravel Sanctum

### 🏢 Gestión de Clubes
- Crear, editar y eliminar clubes
- Asignar categorías a clubes
- Gestión de logos e información básica
- Visualización de jugadores por club

### ⚽ Gestión de Jugadores
- Registro completo con datos personales
- Fotos de carnet e identificación
- Información de representantes legales
- Estados: "pendiente" y "activo"
- Asignación a categorías por edad
- Números de dorsal
- Sistema de aprobación de jugadores

### 🏆 Gestión de Categorías
- Crear categorías por edad/nivel
- Asignar categorías a clubes
- Gestión de estados activo/inactivo

### 👨‍💼 Gestión de Entrenadores
- Registro completo de entrenadores
- Asignación a clubes
- Documentación personal

### 📊 Contenido y Exhibiciones
- Sistema de contenido multimedia
- Gestión de exhibiciones y torneos

## 🛠️ Tecnologías Utilizadas

### Backend
- **Framework**: Laravel 8.75
- **PHP**: 7.3 o 8.0
- **Base de datos**: MySQL 8.0.30
- **Autenticación**: Laravel Sanctum + UI
- **QR Codes**: Endroid QR Code + Simple QR Code

### Frontend
- **CSS Framework**: Bootstrap 5.1.3
- **JavaScript**: Vue.js 2.6.12
- **HTTP Client**: Axios
- **Build Tool**: Laravel Mix 6.0.6
- **Preprocessor**: Sass

## 📁 Estructura de Base de Datos

### Tablas Principales
- `users` - Usuarios del sistema (administradores/entrenadores)
- `clubes` - Clubes de fútbol sala
- `categorias` - Categorías por edad/nivel
- `clubes_categorias` - Relación muchos a muchos
- `jugadores` - Jugadores registrados
- `entrenadores` - Entrenadores de los clubes
- `contenidos` - Contenido del sistema
- `exhibiciones` - Exhibiciones/torneos

### Datos de Ejemplo
El sistema incluye datos de prueba con:
- 6 categorías (menores, mayores, Sub10, etc.)
- 2 clubes con logos
- 8 usuarios (1 administrador, 7 entrenadores)
- Jugadores con estados pendientes y activos

## 🔧 Instalación y Configuración

### Requisitos Previos
- PHP 7.3 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM

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

5. **Configurar base de datos**
```bash
# Importar la base de datos
mysql -u [usuario] -p [nombre_db] < ligadefutbolsalas.sql

# O ejecutar migraciones
php artisan migrate
```

6. **Compilar assets**
```bash
npm run dev
# Para producción: npm run production
```

7. **Iniciar el servidor**
```bash
php artisan serve
```

### Credenciales de Acceso
- **Administrador**: jerinson@yopmail.com / [contraseña]
- **Entrenador**: entrenadorjjjje@yopmail.com / [contraseña]

## 🎯 Funcionalidades Destacadas

### Sistema de Aprobación de Jugadores
- Los entrenadores registran jugadores (estado "pendiente")
- Los administradores aprueban jugadores (cambio a "activo")
- Notificaciones de jugadores pendientes

### Gestión de Archivos
- Subida de fotos de carnet e identificación
- Almacenamiento seguro de documentos
- Validación de tipos de archivo

### Interfaz Responsiva
- Diseño adaptativo con Bootstrap 5
- Modales para información detallada
- Operaciones AJAX para mejor UX

### Seguridad
- Autenticación con middleware
- Protección CSRF
- Validación de datos
- Roles y permisos

## 📱 Rutas Principales

### Rutas Protegidas (requieren autenticación)
- `/jugadores` - Gestión de jugadores
- `/clubes` - Gestión de clubes
- `/categorias` - Gestión de categorías
- `/entrenadores` - Gestión de entrenadores
- `/usuarios` - Gestión de usuarios
- `/contenidos` - Gestión de contenido
- `/exhibiciones` - Gestión de exhibiciones

### Rutas Públicas
- `/` - Página de bienvenida
- `/home` - Dashboard principal
- `/jugadores-pendientes` - Jugadores pendientes de aprobación

## 🔍 Características Técnicas

### Arquitectura MVC
- Separación clara de responsabilidades
- Modelos Eloquent bien estructurados
- Controladores organizados por funcionalidad

### Relaciones Eloquent
- Relaciones muchos a muchos (clubes-categorías)
- Relaciones uno a muchos (clubes-entrenadores)
- Relaciones uno a muchos (clubes-jugadores)

### Validación y Seguridad
- Validación de formularios
- Sanitización de datos
- Protección contra inyección SQL
- Autenticación segura

## 🚀 Despliegue

### Producción
1. Configurar variables de entorno para producción
2. Ejecutar `composer install --optimize-autoloader --no-dev`
3. Ejecutar `npm run production`
4. Configurar servidor web (Apache/Nginx)
5. Configurar base de datos de producción

### Entornos Soportados
- **Desarrollo**: Local con Laravel Sail o XAMPP/WAMP
- **Pruebas**: Servidor de staging
- **Producción**: Servidor de producción

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

**Jerinson** - Desarrollador del sistema Liga Fútbol Sala

## 📞 Soporte

Para soporte técnico o consultas sobre el proyecto, contactar a través de:
- Email: [email_contacto]
- Documentación: [URL_documentacion]

---

**Liga Fútbol Sala** - Sistema de Gestión Integral para Ligas Deportivas
