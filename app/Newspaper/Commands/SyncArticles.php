<?php

declare(strict_types=1);

namespace App\Newspaper\Commands;

use App\Newspaper\Queries\ArticlesDiff;
use App\Newspaper\Article;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Newspaper\Organization;
use Illuminate\Support\Facades\Bus;

class SyncArticles
{
    use DispatchesJobs;

    public function __invoke(ArticlesDiff $articlesDiff): void
    {
        foreach (Organization::get() as $organization) 
        {
            $jobs = [];

            foreach ($articlesDiff($organization->id)->additions() as $externalArticle) 
            {
                $jobs[] = new ProcessArticle($externalArticle);
            }
            
            Bus::batch($jobs)->name('article-scraping:' . $organization->name)->dispatch();
        }
    }
}