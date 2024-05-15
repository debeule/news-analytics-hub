<?php

declare(strict_types=1);

namespace App\Article\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncArticleDomain
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $this->DispatchSync(new SyncArticles);
    }
}