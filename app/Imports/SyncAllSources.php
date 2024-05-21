<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\SyncArticleDomain;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class SyncAllSources implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public function handle(): void
    {
        $syncArticleDomain = new SyncArticleDomain;
        $syncArticleDomain();
    }
}