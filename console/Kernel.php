<?php

namespace Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\ScrapeArticlesListController;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(new ScrapeArticlesListController)->everySixHours();
        
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        
        $schedule->command('queue:prune-batches')->daily();
    }
    
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
