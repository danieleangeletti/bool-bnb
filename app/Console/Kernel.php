<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ExpireSponsorships;
use App\Console\Commands\DestroyExpiredSponsorships;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
{
    $schedule->command('sponsorships:expire')->hourly();
    $schedule->command('sponsorships:destroy-expired')->hourly(); // Esegui il comando per eliminare le sponsorizzazioni scadute ogni ora
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
