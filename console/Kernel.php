<?php

declare(strict_types=1);

namespace Console;

use App\Imports\SyncAllDomains;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncAllDomains)->everySixHours();
        
        // $schedule->command('horizon:snapshot')->everyFiveMinutes();
        
        // $schedule->command('queue:prune-batches')->daily();
    }
    
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
