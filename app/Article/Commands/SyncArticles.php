<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Article\Queries\ArticlesDiff;
use App\Entity\Organization;
use App\Imports\ProcessArticle;
use App\Imports\ScrapeArticle;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class SyncArticles implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $tries = 3;

    public function __construct(
        private Organization $organization
    ) {}

    public function __invoke(ArticlesDiff $articlesDiff): void
    {
            $jobs = [];
            
            $i = 0;
            foreach ($articlesDiff($this->organization->id)->additions() as $scraperArticle) 
            {
                $scrapeJob = new ScrapeArticle($scraperArticle);

                $jobs[] = $scrapeJob->chain([
                    new ProcessArticle($scraperArticle),
                ]);

                $i++;
                if($i >= 3) break;
            }

            if(count($jobs) === 0) throw new \Exception('Scraping arrticles list failed.');

            Bus::batch($jobs)
                ->name('article-scraping:' . $this->organization->name)
                ->dispatch();
    }
}