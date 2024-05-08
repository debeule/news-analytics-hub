<?php

declare(strict_types=1);

namespace App\Newspaper\Commands;

use App\Newspaper\Queries\ArticlesDiff;
use App\Newspaper\Article;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncArticles
{
    use DispatchesJobs;

    public function __construct(
        private ProcessData $processData = new ProcessData,
    ){}

    public function __invoke(ArticlesDiff $articlesDiff): void
    {
        #TODO: replace config file with organizations records
        foreach (config('scraping.organizations') as $key => $organization) 
        {
            $jobs = [];

            foreach ($articlesDiff($key)->additions() as $externalArticle) 
            {
                #TODO: add queue job to be dispatched in batch per organization
                $jobs[] = new ProcessArticle($externalArticle);
            }

            Bus::batch($jobs)->dispatch();
        }
    }
}