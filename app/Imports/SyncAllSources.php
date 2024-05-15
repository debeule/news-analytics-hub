<?php

declare(strict_types=1);

namespace App\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Article\Commands\SyncArticles;

final class SyncAllSources implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $this->DispatchSync(new SyncArticles);
    }
}