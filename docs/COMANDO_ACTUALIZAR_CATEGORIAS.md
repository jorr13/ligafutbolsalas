# Comando de Actualización de Categorías de Jugadores

## Descripción

Este comando actualiza automáticamente las categorías de todos los jugadores basándose en su **año de nacimiento**, según las reglas oficiales de la Liga de Fútbol Sala (L.F.S.C.).

## Reglas de Categorización

Las categorías se asignan según el año de nacimiento, **NO según la edad actual del jugador**:

| Categoría | Años de Nacimiento | Edades en 2026 |
|-----------|-------------------|----------------|
| SUB-8     | 2019-2020         | 6 y 7 años     |
| SUB-10    | 2017-2018         | 8 y 9 años     |
| SUB-12    | 2015-2016         | 10 y 11 años   |
| SUB-14    | 2013-2014         | 12 y 13 años   |
| SUB-16    | 2011-2012         | 14 y 15 años   |
| SUB-18    | 2009-2010         | 16 y 17 años   |

### Ejemplo Práctico

Un jugador nacido el **04/07/2018** (como LUIS ALEJANDRO):
- **Edad actual**: 7 años
- **Categoría correcta**: SUB-10 (porque nació en 2018)

Aunque actualmente tenga 7 años, debe jugar en SUB-10 porque se toma como referencia el **año de nacimiento (2018)**.

## Uso del Comando

### 1. Modo de Prueba (Recomendado primero)

Ejecuta el comando en modo de prueba para ver qué cambios se aplicarían **sin modificar** la base de datos:

```bash
php artisan jugadores:actualizar-categorias --dry-run
```

Este modo te mostrará:
- Qué jugadores serán actualizados
- Categoría actual vs nueva categoría
- Un resumen completo de los cambios

### 2. Aplicar Cambios en Producción

Una vez verificado el resultado en modo de prueba, ejecuta el comando para aplicar los cambios:

```bash
php artisan jugadores:actualizar-categorias
```

### 3. Especificar un Año de Referencia Diferente

Si necesitas calcular las categorías para un año específico (por ejemplo, para preparar la temporada 2027):

```bash
php artisan jugadores:actualizar-categorias --year=2027
```

### 4. Combinación de Opciones

```bash
php artisan jugadores:actualizar-categorias --dry-run --year=2027
```

## Cuándo Ejecutar el Comando

Se recomienda ejecutar este comando:

1. **Al inicio de cada temporada** (inicio de año)
2. **Cuando se registran nuevos jugadores** en masa
3. **Cuando detectes inconsistencias** en las categorías

## Salida del Comando

El comando muestra:

### Tabla de Resultados
```
+---------------------------+----------+------+------------------+-----------------+--------------+
| Jugador                   | Año Nac. | Edad | Categoría Actual | Nueva Categoría | Estado       |
+---------------------------+----------+------+------------------+-----------------+--------------+
| LUIS ALEJANDRO PEÑA       | 2018     | 7    | SUB-8            | SUB-10          | Actualizado  |
| JUAN RODRIGUEZ            | 2015     | 10   | SUB-12           | SUB-12          | Sin cambios  |
+---------------------------+----------+------+------------------+-----------------+--------------+
```

### Resumen
```
===================================================
RESUMEN DE LA ACTUALIZACIÓN
===================================================
Total procesados:     150
  ✓ Actualizados:     25
  ○ Sin cambios:      120
  ! Mayores de 18:    3
  ✗ Sin categoría:    2
  ✗ Errores:          0
===================================================
```

## Estados Posibles

- **✓ Actualizado** (verde): La categoría del jugador fue actualizada
- **○ Sin cambios** (azul): El jugador ya tiene la categoría correcta
- **! Mayores de 18** (amarillo): Jugadores excluidos por ser mayores de edad
- **✗ Sin categoría** (rojo): No se encontró una categoría correspondiente en el sistema
- **✗ Error** (rojo): Ocurrió un error al procesar al jugador

## Automatización

Puedes programar la ejecución automática de este comando usando el Task Scheduler de Laravel.

En `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Ejecutar cada 1 de enero a las 00:00
    $schedule->command('jugadores:actualizar-categorias')
             ->yearlyOn(1, 1, '00:00');
}
```

O ejecutarlo mensualmente si prefieres:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('jugadores:actualizar-categorias')
             ->monthly();
}
```

## Notas Importantes

1. **Backup**: Aunque el comando es seguro, se recomienda hacer un respaldo de la base de datos antes de ejecutarlo en producción.

2. **Prueba primero**: Siempre usa `--dry-run` primero para verificar los cambios.

3. **Clubes y Categorías**: El comando respeta las categorías disponibles en cada club. Si un club no tiene una categoría registrada, el comando buscará en todas las categorías disponibles del sistema.

4. **Fecha de Nacimiento Requerida**: Los jugadores sin fecha de nacimiento no serán procesados.

5. **Año de Nacimiento**: El cálculo se basa en el **año completo** de nacimiento, no en la edad exacta en meses.

## Solución de Problemas

### No se encontraron jugadores
```
No se encontraron jugadores con fecha de nacimiento.
```
**Solución**: Verifica que los jugadores tengan el campo `fecha_nacimiento` completado.

### No se encuentra categoría para un jugador
```
✗ Sin categoría: X jugadores
```
**Solución**: Verifica que existan categorías en el sistema que coincidan con los nombres estándar (SUB-8, SUB-10, SUB-12, SUB-14, SUB-16, SUB-18).

## Soporte

Si encuentras algún problema o necesitas ajustar las reglas de categorización, revisa:
- Modelo: `app/Models/Categorias.php` → método `getClaveCategoriaPorFechaNacimiento()`
- Comando: `app/Console/Commands/ActualizarCategoriasJugadores.php`
