<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Newspaper\Queries\ArticlesDiff;
use App\Newspaper\Article;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Newspaper\Organization;
use Illuminate\Support\Facades\Bus;
use App\Imports\ProcessArticle;

class SyncArticles
{
    use DispatchesJobs;

    public function __invoke(ArticlesDiff $articlesDiff): void
    {
        dd('a');
        foreach (Organization::where('type', 'source-newspaper')->get() as $organization) 
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