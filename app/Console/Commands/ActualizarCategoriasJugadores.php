<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jugadores;
use App\Models\Categorias;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActualizarCategoriasJugadores extends Command
{
    /**
     * Nombre y firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'jugadores:actualizar-categorias 
                            {--dry-run : Ejecutar en modo de prueba sin guardar cambios}
                            {--year= : Año de referencia (por defecto el año actual)}';

    /**
     * Descripción del comando.
     *
     * @var string
     */
    protected $description = 'Actualiza las categorías de todos los jugadores basándose en su año de nacimiento según las reglas de L.F.S.C.';

    /**
     * Ejecutar el comando.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $añoReferencia = $this->option('year') ?? now()->year;

        $this->info("===================================================");
        $this->info("Actualización de Categorías de Jugadores por Año de Nacimiento");
        $this->info("===================================================");
        $this->info("Año de referencia: {$añoReferencia}");
        $this->info("Modo: " . ($dryRun ? "PRUEBA (no se guardarán cambios)" : "PRODUCCIÓN"));
        $this->info("===================================================\n");

        // Obtener todos los jugadores con fecha de nacimiento
        $jugadores = Jugadores::with(['categoria', 'club'])
            ->whereNotNull('fecha_nacimiento')
            ->get();

        if ($jugadores->isEmpty()) {
            $this->warn("No se encontraron jugadores con fecha de nacimiento.");
            return 0;
        }

        $this->info("Total de jugadores a procesar: {$jugadores->count()}\n");

        // Contadores
        $actualizados = 0;
        $sinCambios = 0;
        $sinCategoria = 0;
        $mayoresDe18 = 0;
        $errores = 0;

        // Obtener todas las categorías disponibles
        $todasCategorias = Categorias::all();

        $this->info("Procesando jugadores...\n");

        // Crear tabla de progreso
        $headers = ['Jugador', 'Año Nac.', 'Edad', 'Categoría Actual', 'Nueva Categoría', 'Estado'];
        $rows = [];

        foreach ($jugadores as $jugador) {
            try {
                $fecha = Carbon::parse($jugador->fecha_nacimiento);
                $añoNacimiento = (int) $fecha->format('Y');
                $edad = $fecha->age;
                
                // Determinar la categoría según el año de nacimiento
                $claveCategoriaCorrecta = $this->obtenerCategoriaPorAñoNacimiento($añoNacimiento, $añoReferencia);
                
                // Jugador mayor de 18 años
                if ($claveCategoriaCorrecta === null) {
                    $mayoresDe18++;
                    $rows[] = [
                        $jugador->nombre,
                        $añoNacimiento,
                        $edad,
                        $jugador->categoria->nombre ?? 'Sin categoría',
                        'Mayor de 18',
                        '<fg=yellow>Excluido</>'
                    ];
                    continue;
                }

                // Buscar categoría disponible en el club del jugador
                $categoriasDisponibles = $todasCategorias;
                
                if ($jugador->club_id) {
                    $idsCategoriasClub = DB::table('clubes_categorias')
                        ->where('club_id', $jugador->club_id)
                        ->pluck('categoria_id')
                        ->toArray();

                    if (!empty($idsCategoriasClub)) {
                        $categoriasDisponibles = $todasCategorias->whereIn('id', $idsCategoriasClub);
                    }
                }

                // Buscar la categoría que coincida con la clave
                $categoriaId = Categorias::findCategoriaIdPorClave($categoriasDisponibles, $claveCategoriaCorrecta);

                // Si no se encuentra en el club, buscar en todas las categorías
                if (!$categoriaId && $jugador->club_id) {
                    $categoriaId = Categorias::findCategoriaIdPorClave($todasCategorias, $claveCategoriaCorrecta);
                }

                // Si no se encontró categoría válida
                if (!$categoriaId) {
                    $sinCategoria++;
                    $rows[] = [
                        $jugador->nombre,
                        $añoNacimiento,
                        $edad,
                        $jugador->categoria->nombre ?? 'Sin categoría',
                        strtoupper($claveCategoriaCorrecta),
                        '<fg=red>No encontrada</>'
                    ];
                    continue;
                }

                // Obtener el nombre de la nueva categoría
                $nuevaCategoria = $todasCategorias->firstWhere('id', $categoriaId);

                // Verificar si necesita actualización
                if ($jugador->categoria_id != $categoriaId) {
                    if (!$dryRun) {
                        DB::table('jugadores')
                            ->where('id', $jugador->id)
                            ->update([
                                'categoria_id' => $categoriaId,
                                'updated_at' => now()
                            ]);
                    }
                    
                    $actualizados++;
                    $rows[] = [
                        $jugador->nombre,
                        $añoNacimiento,
                        $edad,
                        $jugador->categoria->nombre ?? 'Sin categoría',
                        $nuevaCategoria->nombre,
                        '<fg=green>Actualizado</>'
                    ];
                } else {
                    $sinCambios++;
                    $rows[] = [
                        $jugador->nombre,
                        $añoNacimiento,
                        $edad,
                        $jugador->categoria->nombre ?? 'Sin categoría',
                        $nuevaCategoria->nombre,
                        '<fg=blue>Sin cambios</>'
                    ];
                }

            } catch (\Exception $e) {
                $errores++;
                $rows[] = [
                    $jugador->nombre,
                    '-',
                    '-',
                    $jugador->categoria->nombre ?? 'Sin categoría',
                    '-',
                    '<fg=red>Error: ' . $e->getMessage() . '</>'
                ];
            }
        }

        // Mostrar tabla de resultados
        $this->table($headers, $rows);

        // Mostrar resumen
        $this->info("\n===================================================");
        $this->info("RESUMEN DE LA ACTUALIZACIÓN");
        $this->info("===================================================");
        $this->info("Total procesados:     {$jugadores->count()}");
        $this->line("  <fg=green>✓ Actualizados:     {$actualizados}</>");
        $this->line("  <fg=blue>○ Sin cambios:      {$sinCambios}</>");
        $this->line("  <fg=yellow>! Mayores de 18:    {$mayoresDe18}</>");
        $this->line("  <fg=red>✗ Sin categoría:    {$sinCategoria}</>");
        $this->line("  <fg=red>✗ Errores:          {$errores}</>");
        $this->info("===================================================\n");

        if ($dryRun) {
            $this->warn("MODO PRUEBA: No se guardaron cambios. Ejecuta sin --dry-run para aplicar los cambios.");
        } else {
            $this->info("✓ Actualización completada exitosamente.");
        }

        return 0;
    }

    /**
     * Determina la clave de categoría según el año de nacimiento.
     * Basado en la tabla L.F.S.C.:
     * - SUB-8:  2019-2020 (6 y 7 años)
     * - SUB-10: 2017-2018 (8 y 9 años)
     * - SUB-12: 2015-2016 (10 y 11 años)
     * - SUB-14: 2013-2014 (12 y 13 años)
     * - SUB-16: 2011-2012 (14 y 15 años)
     * - SUB-18: 2009-2010 (16 y 17 años)
     *
     * @param int $añoNacimiento
     * @param int $añoReferencia
     * @return string|null
     */
    private function obtenerCategoriaPorAñoNacimiento(int $añoNacimiento, int $añoReferencia): ?string
    {
        // Calcular la edad que tendrá el jugador en el año de referencia
        $edadEnAñoReferencia = $añoReferencia - $añoNacimiento;

        // Mayor de 18 años
        if ($edadEnAñoReferencia >= 18) {
            return null;
        }

        // SUB-18: nacidos 2009-2010 (16 y 17 años en 2026)
        if (in_array($añoNacimiento, [$añoReferencia - 17, $añoReferencia - 16])) {
            return 'sub18';
        }

        // SUB-16: nacidos 2011-2012 (14 y 15 años en 2026)
        if (in_array($añoNacimiento, [$añoReferencia - 15, $añoReferencia - 14])) {
            return 'sub16';
        }

        // SUB-14: nacidos 2013-2014 (12 y 13 años en 2026)
        if (in_array($añoNacimiento, [$añoReferencia - 13, $añoReferencia - 12])) {
            return 'sub14';
        }

        // SUB-12: nacidos 2015-2016 (10 y 11 años en 2026)
        if (in_array($añoNacimiento, [$añoReferencia - 11, $añoReferencia - 10])) {
            return 'sub12';
        }

        // SUB-10: nacidos 2017-2018 (8 y 9 años en 2026)
        if (in_array($añoNacimiento, [$añoReferencia - 9, $añoReferencia - 8])) {
            return 'sub10';
        }

        // SUB-8: nacidos 2019-2020 (6 y 7 años en 2026)
        if (in_array($añoNacimiento, [$añoReferencia - 7, $añoReferencia - 6])) {
            return 'sub8';
        }

        // Jugadores muy pequeños (menores de 6 años) también van a SUB-8
        if ($edadEnAñoReferencia < 6) {
            return 'sub8';
        }

        return null;
    }
}
