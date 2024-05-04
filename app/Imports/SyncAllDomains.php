<?php

declare(strict_types=1);

namespace App\Imports;

use App\Location\Commands\SyncRawDomain;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class SyncAllDomains implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $syncRawDomain = new SyncRawDomain();
        $syncRawDomain();
        
    }
}