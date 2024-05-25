<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Entity\Organization;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class SyncArticleDomain
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __invoke(): void
    {
        foreach (Organization::where('sector', 'source_newspaper')->get() as $organization) 
        {
            $this->dispatch(new SyncArticles($organization));
        }
    }
}