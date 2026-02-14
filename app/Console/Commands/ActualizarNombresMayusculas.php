<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jugadores;
use App\Models\Entrenadores;
use App\Models\Arbitros;
use Illuminate\Support\Facades\DB;

class ActualizarNombresMayusculas extends Command
{
    /**
     * Nombre y firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'nombres:actualizar-mayusculas 
                            {--dry-run : Ejecutar en modo de prueba sin guardar cambios}
                            {--tipo= : Tipo específico a actualizar: jugadores, entrenadores, arbitros (por defecto todos)}';

    /**
     * Descripción del comando.
     *
     * @var string
     */
    protected $description = 'Actualiza todos los nombres de jugadores, entrenadores y árbitros a mayúsculas';

    /**
     * Ejecutar el comando.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $tipo = $this->option('tipo');

        $this->info("===================================================");
        $this->info("Actualización de Nombres a Mayúsculas");
        $this->info("===================================================");
        $this->info("Modo: " . ($dryRun ? "PRUEBA (no se guardarán cambios)" : "PRODUCCIÓN"));
        if ($tipo) {
            $this->info("Tipo: " . strtoupper($tipo));
        } else {
            $this->info("Procesando: Jugadores, Entrenadores y Árbitros");
        }
        $this->info("===================================================\n");

        $totalActualizados = 0;
        $totalProcesados = 0;

        // Procesar jugadores
        if (!$tipo || $tipo === 'jugadores') {
            $resultado = $this->procesarJugadores($dryRun);
            $totalActualizados += $resultado['actualizados'];
            $totalProcesados += $resultado['procesados'];
        }

        // Procesar entrenadores
        if (!$tipo || $tipo === 'entrenadores') {
            $resultado = $this->procesarEntrenadores($dryRun);
            $totalActualizados += $resultado['actualizados'];
            $totalProcesados += $resultado['procesados'];
        }

        // Procesar árbitros
        if (!$tipo || $tipo === 'arbitros') {
            $resultado = $this->procesarArbitros($dryRun);
            $totalActualizados += $resultado['actualizados'];
            $totalProcesados += $resultado['procesados'];
        }

        // Resumen final
        $this->info("\n===================================================");
        $this->info("RESUMEN GENERAL");
        $this->info("===================================================");
        $this->info("Total procesados:     {$totalProcesados}");
        $this->line("  <fg=green>✓ Actualizados:     {$totalActualizados}</>");
        $this->line("  <fg=blue>○ Sin cambios:      " . ($totalProcesados - $totalActualizados) . "</>");
        $this->info("===================================================\n");

        if ($dryRun) {
            $this->warn("MODO PRUEBA: No se guardaron cambios. Ejecuta sin --dry-run para aplicar los cambios.");
        } else {
            $this->info("✓ Actualización completada exitosamente.");
        }

        return 0;
    }

    /**
     * Procesar jugadores
     */
    private function procesarJugadores(bool $dryRun): array
    {
        $this->info("📋 Procesando JUGADORES...\n");

        $jugadores = Jugadores::whereNotNull('nombre')->get();
        $actualizados = 0;
        $procesados = 0;

        $headers = ['ID', 'Nombre', 'Representante Actual', 'Representante Mayúsculas', 'Estado'];
        $rows = [];

        foreach ($jugadores as $jugador) {
            $procesados++;
            $nombreOriginal = $jugador->nombre;
            $nombreMayusculas = mb_strtoupper($nombreOriginal, 'UTF-8');
            
            $representanteOriginal = $jugador->nombre_representante;
            $representanteMayusculas = $representanteOriginal ? mb_strtoupper($representanteOriginal, 'UTF-8') : null;

            $necesitaActualizacion = false;
            $cambioNombre = false;
            $cambioRepresentante = false;
            
            // Verificar si el nombre necesita actualización
            if ($nombreOriginal !== $nombreMayusculas) {
                $necesitaActualizacion = true;
                $cambioNombre = true;
            }
            
            // Verificar si el nombre del representante necesita actualización
            if ($representanteOriginal && $representanteOriginal !== $representanteMayusculas) {
                $necesitaActualizacion = true;
                $cambioRepresentante = true;
            }

            if ($necesitaActualizacion) {
                $actualizados++;
                
                if (!$dryRun) {
                    DB::table('jugadores')
                        ->where('id', $jugador->id)
                        ->update([
                            'nombre' => $nombreMayusculas,
                            'nombre_representante' => $representanteMayusculas,
                            'updated_at' => now()
                        ]);
                }

                // Solo mostrar los primeros 20 para no saturar la consola
                if ($actualizados <= 20) {
                    $nombreMostrar = $cambioNombre ? mb_substr($nombreOriginal, 0, 20) : '✓';
                    $repAntesMostrar = $cambioRepresentante ? mb_substr($representanteOriginal, 0, 25) : '-';
                    $repDespuesMostrar = $cambioRepresentante ? mb_substr($representanteMayusculas, 0, 25) : '-';
                    
                    $rows[] = [
                        $jugador->id,
                        $nombreMostrar,
                        $repAntesMostrar,
                        $repDespuesMostrar,
                        '<fg=green>Actualizado</>'
                    ];
                }
            }
        }

        if (!empty($rows)) {
            if ($actualizados > 20) {
                $this->table($headers, array_slice($rows, 0, 20));
                $this->line("  ... y " . ($actualizados - 20) . " jugadores más.");
            } else {
                $this->table($headers, $rows);
            }
        } else {
            $this->line("  <fg=blue>○ Todos los nombres ya están en mayúsculas</>");
        }

        $this->info("\nJugadores - Total procesados: {$procesados}");
        $this->line("  <fg=green>✓ Actualizados:     {$actualizados}</>");
        $this->line("  <fg=blue>○ Sin cambios:      " . ($procesados - $actualizados) . "</>\n");

        return ['procesados' => $procesados, 'actualizados' => $actualizados];
    }

    /**
     * Procesar entrenadores
     */
    private function procesarEntrenadores(bool $dryRun): array
    {
        $this->info("📋 Procesando ENTRENADORES...\n");

        $entrenadores = Entrenadores::whereNotNull('nombre')->get();
        $actualizados = 0;
        $procesados = 0;

        $headers = ['ID', 'Nombre Actual', 'Nombre en Mayúsculas', 'Estado'];
        $rows = [];

        foreach ($entrenadores as $entrenador) {
            $procesados++;
            $nombreOriginal = $entrenador->nombre;
            $nombreMayusculas = mb_strtoupper($nombreOriginal, 'UTF-8');

            if ($nombreOriginal !== $nombreMayusculas) {
                $actualizados++;
                
                if (!$dryRun) {
                    DB::table('entrenadores')
                        ->where('id', $entrenador->id)
                        ->update([
                            'nombre' => $nombreMayusculas,
                            'updated_at' => now()
                        ]);
                }

                // Solo mostrar los primeros 20
                if ($actualizados <= 20) {
                    $rows[] = [
                        $entrenador->id,
                        mb_substr($nombreOriginal, 0, 35),
                        mb_substr($nombreMayusculas, 0, 35),
                        '<fg=green>Actualizado</>'
                    ];
                }
            }
        }

        if (!empty($rows)) {
            if ($actualizados > 20) {
                $this->table($headers, array_slice($rows, 0, 20));
                $this->line("  ... y " . ($actualizados - 20) . " entrenadores más.");
            } else {
                $this->table($headers, $rows);
            }
        } else {
            $this->line("  <fg=blue>○ Todos los nombres ya están en mayúsculas</>");
        }

        $this->info("\nEntrenadores - Total procesados: {$procesados}");
        $this->line("  <fg=green>✓ Actualizados:     {$actualizados}</>");
        $this->line("  <fg=blue>○ Sin cambios:      " . ($procesados - $actualizados) . "</>\n");

        return ['procesados' => $procesados, 'actualizados' => $actualizados];
    }

    /**
     * Procesar árbitros
     */
    private function procesarArbitros(bool $dryRun): array
    {
        $this->info("📋 Procesando ÁRBITROS...\n");

        $arbitros = Arbitros::whereNotNull('nombre')->get();
        $actualizados = 0;
        $procesados = 0;

        $headers = ['ID', 'Nombre Actual', 'Nombre en Mayúsculas', 'Estado'];
        $rows = [];

        foreach ($arbitros as $arbitro) {
            $procesados++;
            $nombreOriginal = $arbitro->nombre;
            $nombreMayusculas = mb_strtoupper($nombreOriginal, 'UTF-8');

            if ($nombreOriginal !== $nombreMayusculas) {
                $actualizados++;
                
                if (!$dryRun) {
                    DB::table('arbitros')
                        ->where('id', $arbitro->id)
                        ->update([
                            'nombre' => $nombreMayusculas,
                            'updated_at' => now()
                        ]);
                }

                // Solo mostrar los primeros 20
                if ($actualizados <= 20) {
                    $rows[] = [
                        $arbitro->id,
                        mb_substr($nombreOriginal, 0, 35),
                        mb_substr($nombreMayusculas, 0, 35),
                        '<fg=green>Actualizado</>'
                    ];
                }
            }
        }

        if (!empty($rows)) {
            if ($actualizados > 20) {
                $this->table($headers, array_slice($rows, 0, 20));
                $this->line("  ... y " . ($actualizados - 20) . " árbitros más.");
            } else {
                $this->table($headers, $rows);
            }
        } else {
            $this->line("  <fg=blue>○ Todos los nombres ya están en mayúsculas</>");
        }

        $this->info("\nÁrbitros - Total procesados: {$procesados}");
        $this->line("  <fg=green>✓ Actualizados:     {$actualizados}</>");
        $this->line("  <fg=blue>○ Sin cambios:      " . ($procesados - $actualizados) . "</>\n");

        return ['procesados' => $procesados, 'actualizados' => $actualizados];
    }
}
