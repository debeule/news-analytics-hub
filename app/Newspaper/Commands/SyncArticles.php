<?php

declare(strict_types=1);

namespace App\Newspaper\Commands;

use App\Newspaper\Queries\ArticlesDiff;
use App\Newspaper\Article;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncArticles
{
    use DispatchesJobs;

    // private ArticlesDiff $ArticlesDiff;

    // public function __construct(
    //     public int $organizationId,
    //     ) {
    //         $this->articlesDiff = new ArticlesDiff();
    //     }

    public function __invoke(ArticlesDiff $articlesDiff): void
    {
        foreach (config('scraping.organizations') as $key => $organization) 
        {
            foreach ($articlesDiff($key)->additions() as $externalArticle) 
            {
                $this->dispatchSync(new CreateArticle($externalArticle));
            }
        }
    }
}