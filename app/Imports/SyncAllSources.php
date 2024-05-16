<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\SyncArticles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Queue\SerializesModels;

final class SyncAllSources implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $this->DispatchSync(new SyncArticles);
    }
}