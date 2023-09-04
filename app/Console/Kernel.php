<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\EnviarRecordatorios;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //  $schedule->command(EnviarRecordatorios::class)->dailyAt('10:11');
		 //$schedule->command('recordatorios:enviar')->everyFiveMinutes(); //TEST  
		 $schedule->command('recordatorios:enviar')->everyTwoMinutes(); //TEST  
									
			//valida que tareas se va ejecutar
			//php artisan schedule:list
			
			//ejecuta envio correo
			//php artisan schedule:run
    }	

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
