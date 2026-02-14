# Comando de Actualización de Nombres a Mayúsculas

## Descripción

Este comando actualiza automáticamente todos los nombres de **jugadores**, **entrenadores** y **árbitros** a mayúsculas para mantener consistencia en la base de datos.

## ⚙️ Configuración Automática

Los modelos ya están configurados para convertir automáticamente los nombres a mayúsculas al momento de guardar:

### Jugadores
```php
// app/Models/Jugadores.php
public function setNombreAttribute($value): void
{
    $this->attributes['nombre'] = $value ? mb_strtoupper($value, 'UTF-8') : $value;
}

public function setNombreRepresentanteAttribute($value): void
{
    $this->attributes['nombre_representante'] = $value ? mb_strtoupper($value, 'UTF-8') : $value;
}
```

### Entrenadores
```php
// app/Models/Entrenadores.php
public function setNombreAttribute($value): void
{
    $this->attributes['nombre'] = $value ? mb_strtoupper($value, 'UTF-8') : $value;
}
```

### Árbitros
```php
// app/Models/Arbitros.php
public function setNombreAttribute($value): void
{
    $this->attributes['nombre'] = $value ? mb_strtoupper($value, 'UTF-8') : $value;
}
```

**✅ Esto significa que todos los nuevos registros se guardarán automáticamente en mayúsculas.**

---

## 🚀 Uso del Comando

### 1. Modo de Prueba (Recomendado primero)

Ejecuta el comando en modo de prueba para ver qué cambios se aplicarían **sin modificar** la base de datos:

```bash
php artisan nombres:actualizar-mayusculas --dry-run
```

### 2. Actualizar Todos (Jugadores, Entrenadores y Árbitros)

```bash
php artisan nombres:actualizar-mayusculas
```

### 3. Actualizar Solo un Tipo Específico

**Solo Jugadores:**
```bash
php artisan nombres:actualizar-mayusculas --tipo=jugadores
```

**Solo Entrenadores:**
```bash
php artisan nombres:actualizar-mayusculas --tipo=entrenadores
```

**Solo Árbitros:**
```bash
php artisan nombres:actualizar-mayusculas --tipo=arbitros
```

### 4. Combinación de Opciones

```bash
# Probar solo jugadores en modo dry-run
php artisan nombres:actualizar-mayusculas --tipo=jugadores --dry-run
```

---

## 📊 Salida del Comando

### Ejemplo de Ejecución:

```
===================================================
Actualización de Nombres a Mayúsculas
===================================================
Modo: PRUEBA (no se guardarán cambios)
Procesando: Jugadores, Entrenadores y Árbitros
===================================================

📋 Procesando JUGADORES...

+----+--------------------------------+--------------------------------+---------------+--------------+
| ID | Nombre Actual                  | Nombre en Mayúsculas           | Representante | Estado       |
+----+--------------------------------+--------------------------------+---------------+--------------+
| 5  | Luis Alejandro Peña            | LUIS ALEJANDRO PEÑA            | ✓             | Actualizado  |
| 12 | María González                 | MARÍA GONZÁLEZ                 |               | Actualizado  |
| 23 | José Antonio Rodríguez         | JOSÉ ANTONIO RODRÍGUEZ         | ✓             | Actualizado  |
+----+--------------------------------+--------------------------------+---------------+--------------+

Jugadores - Total procesados: 827
  ✓ Actualizados:     156
  ○ Sin cambios:      671

📋 Procesando ENTRENADORES...

+----+--------------------------------+--------------------------------+--------------+
| ID | Nombre Actual                  | Nombre en Mayúsculas           | Estado       |
+----+--------------------------------+--------------------------------+--------------+
| 2  | Carlos Alberto Méndez          | CARLOS ALBERTO MÉNDEZ          | Actualizado  |
| 7  | Ana María Fernández            | ANA MARÍA FERNÁNDEZ            | Actualizado  |
+----+--------------------------------+--------------------------------+--------------+

Entrenadores - Total procesados: 45
  ✓ Actualizados:     23
  ○ Sin cambios:      22

📋 Procesando ÁRBITROS...

+----+--------------------------------+--------------------------------+--------------+
| ID | Nombre Actual                  | Nombre en Mayúsculas           | Estado       |
+----+--------------------------------+--------------------------------+--------------+
| 1  | Pedro José Ramírez             | PEDRO JOSÉ RAMÍREZ             | Actualizado  |
+----+--------------------------------+--------------------------------+--------------+

Árbitros - Total procesados: 18
  ✓ Actualizados:     8
  ○ Sin cambios:      10

===================================================
RESUMEN GENERAL
===================================================
Total procesados:     890
  ✓ Actualizados:     187
  ○ Sin cambios:      703
===================================================

MODO PRUEBA: No se guardaron cambios. Ejecuta sin --dry-run para aplicar los cambios.
```

---

## 🎯 Características del Comando

### ✅ Qué actualiza:

1. **Jugadores:**
   - Campo `nombre`
   - Campo `nombre_representante`

2. **Entrenadores:**
   - Campo `nombre`

3. **Árbitros:**
   - Campo `nombre`

### 🔍 Ventajas:

- ✅ **Modo de prueba** (`--dry-run`) para verificar antes de aplicar
- ✅ **Filtrado por tipo** para actualizar solo jugadores, entrenadores o árbitros
- ✅ **Tabla detallada** mostrando los primeros 20 registros actualizados
- ✅ **Resumen completo** con estadísticas de procesamiento
- ✅ **Soporte UTF-8** para caracteres especiales (á, é, í, ó, ú, ñ, etc.)
- ✅ **Actualización automática** del campo `updated_at`
- ✅ **Optimizado** para grandes volúmenes de datos

---

## 📝 Comportamiento Esperado

### Antes del comando:
```
Jugador: Luis Alejandro Peña Hernandez
Representante: Maria González
```

### Después del comando:
```
Jugador: LUIS ALEJANDRO PEÑA HERNANDEZ
Representante: MARIA GONZÁLEZ
```

### Futuros registros (automático):
```
Input:  "juan pérez"
Guardado: "JUAN PÉREZ"
```

---

## 🔄 Cuándo Ejecutar el Comando

Se recomienda ejecutar este comando:

1. **Una sola vez** después de implementar esta funcionalidad (para actualizar registros existentes)
2. **Después de importaciones masivas** de datos externos
3. **Cuando detectes inconsistencias** en el formato de los nombres

**Nota:** No es necesario ejecutarlo periódicamente porque los nuevos registros se guardan automáticamente en mayúsculas gracias a los mutators de los modelos.

---

## 🛡️ Seguridad

### Recomendaciones:

1. **Siempre usa `--dry-run` primero** para verificar los cambios
2. **Haz un backup** de la base de datos antes de ejecutar sin dry-run
3. **Ejecuta en horarios de bajo tráfico** si tienes muchos registros
4. **Verifica los resultados** después de la ejecución

### Backup de base de datos:

```bash
# Ejemplo de backup con mysqldump
mysqldump -u usuario -p base_datos > backup_antes_mayusculas.sql

# Ejecutar el comando
php artisan nombres:actualizar-mayusculas

# Si algo sale mal, restaurar desde el backup
mysql -u usuario -p base_datos < backup_antes_mayusculas.sql
```

---

## 📊 Rendimiento

El comando está optimizado para manejar grandes volúmenes:

- Procesa registros en memoria de manera eficiente
- Actualiza directamente en la base de datos usando `DB::table()`
- Muestra solo los primeros 20 registros en la tabla para evitar saturar la consola
- Proporciona un contador del total de registros procesados

**Tiempo estimado:**
- 1,000 registros: ~5-10 segundos
- 10,000 registros: ~30-60 segundos
- 100,000 registros: ~5-10 minutos

---

## 🔍 Solución de Problemas

### Problema: "No se encontraron registros"
**Causa:** Todos los nombres ya están en mayúsculas  
**Solución:** No es necesario hacer nada, el sistema está correcto

### Problema: "Algunos nombres no se actualizaron"
**Causa:** Nombres con valores `NULL` en la base de datos  
**Solución:** El comando solo procesa registros con nombres no nulos (es el comportamiento correcto)

### Problema: "Los caracteres especiales se ven mal"
**Causa:** Problema de encoding de la base de datos  
**Solución:** Verifica que tus tablas usen `utf8mb4_unicode_ci` como collation

```sql
-- Verificar collation de una tabla
SHOW CREATE TABLE jugadores;

-- Cambiar collation si es necesario
ALTER TABLE jugadores CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 💡 Ejemplos de Uso

### Caso 1: Primera vez implementando la funcionalidad
```bash
# 1. Probar primero
php artisan nombres:actualizar-mayusculas --dry-run

# 2. Si todo se ve bien, aplicar
php artisan nombres:actualizar-mayusculas
```

### Caso 2: Solo quieres actualizar jugadores
```bash
php artisan nombres:actualizar-mayusculas --tipo=jugadores
```

### Caso 3: Verificar solo entrenadores sin cambiar nada
```bash
php artisan nombres:actualizar-mayusculas --tipo=entrenadores --dry-run
```

---

## 🎨 Características Visuales

El comando utiliza colores y símbolos para mejor legibilidad:

- <span style="color: green">✓ Verde</span>: Registros actualizados
- <span style="color: blue">○ Azul</span>: Registros sin cambios
- <span style="color: yellow">!</span> Amarillo: Advertencias
- <span style="color: red">✗ Rojo</span>: Errores

---

## 📚 Resumen

| Aspecto | Detalle |
|---------|---------|
| **Comando** | `nombres:actualizar-mayusculas` |
| **Opciones** | `--dry-run`, `--tipo=jugadores\|entrenadores\|arbitros` |
| **Alcance** | Jugadores, Entrenadores, Árbitros |
| **Campos** | nombre, nombre_representante (solo jugadores) |
| **Seguro** | Sí, con modo dry-run |
| **Reversible** | Sí, con backup de BD |
| **Ejecución** | Una sola vez (inicial) + importaciones |

---

**Fecha de implementación:** 13 de febrero de 2026  
**Autor del comando:** Sistema de gestión Liga de Fútbol Sala  
**Versión Laravel:** 8.83.29
