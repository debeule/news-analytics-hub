<?php

declare(strict_types=1);

namespace App\Article\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Scraper\Commands\ScrapeArticle;
use App\Imports\Values\GuzzleResponse;
use App\Entity\Organization;

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