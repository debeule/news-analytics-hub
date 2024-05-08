<?php

declare(strict_types=1);

namespace App\Newspaper\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncNewspaperDomain
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $this->DispatchSync(new SyncArticles);
    }
}