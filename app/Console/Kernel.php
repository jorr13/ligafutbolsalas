<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Actualizar categorías de jugadores cada 1 de enero a las 00:00
        // Esto asegura que las categorías se ajusten al inicio de cada temporada
        $schedule->command('jugadores:actualizar-categorias')
                 ->yearlyOn(1, 1, '00:00')
                 ->timezone('America/Caracas');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
