<?php

namespace App\Console\Commands;

use App\Models\Entrenadores;
use Illuminate\Console\Command;

class GenerarQrEntrenadoresCommand extends Command
{
    protected $signature = 'entrenadores:generar-qr {--force : Regenerar aunque ya exista QR en base de datos}';

    protected $description = 'Genera o regenera códigos QR para entrenadores (útil para registros existentes sin QR)';

    public function handle(): int
    {
        $force = (bool) $this->option('force');

        $builder = Entrenadores::query()->orderBy('id');
        if (! $force) {
            $builder->where(function ($q) {
                $q->whereNull('qr_code_image')->orWhere('qr_code_image', '');
            });
        }

        $total = (clone $builder)->count();
        if ($total === 0) {
            $this->info('No hay entrenadores que requieran generación de QR.');

            return self::SUCCESS;
        }

        $this->info("Procesando {$total} entrenador(es)...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $ok = 0;
        $err = 0;

        $builder->chunkById(50, function ($entrenadores) use (&$ok, &$err, $bar) {
            foreach ($entrenadores as $entrenador) {
                try {
                    $entrenador->generarQRCode();
                    $ok++;
                } catch (\Throwable $e) {
                    $this->newLine();
                    $this->error("ID {$entrenador->id}: {$e->getMessage()}");
                    $err++;
                }
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);
        $this->info("Listo: {$ok} generado(s).".($err ? " Fallos: {$err}." : ''));

        return $err > 0 ? self::FAILURE : self::SUCCESS;
    }
}
