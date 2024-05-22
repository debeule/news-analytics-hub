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
        foreach (Organization::where('sector', 'source_newspaper')->get() as $organization) 
        {
            $jobs = [];
            
            $i = 0;
            foreach ($articlesDiff($organization->id)->additions() as $scraperArticle) 
            {
                $jobs[] = new ProcessArticle($scraperArticle);

                $i++;
                if($i > 2) break;
            }

            Bus::batch($jobs)
                ->name('article-scraping:' . $organization->name)
                ->dispatch();
        }
    }
}