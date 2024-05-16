<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Article\Queries\ArticlesDiff;
use App\Entity\Organization;
use App\Imports\ProcessArticle;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Bus;

class SyncArticles
{
    use DispatchesJobs;

    public function __invoke(ArticlesDiff $articlesDiff): void
    {
        foreach (Organization::where('type', 'source_newspaper')->get() as $organization) 
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