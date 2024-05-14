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
        private AllArticles $allArticles,
    ){}


    public function __invoke(ArticlesDiff $articlesDiff): void
    {
        foreach ($this->allArticles->get() as $article) 
        {
            $this->DispatchSync(new SyncCategories);
            $this->DispatchSync(new SyncOrganizations);
            $this->DispatchSync(new SyncEntities);
            $this->DispatchSync(new SyncLocations);
            $this->DispatchSync(new SyncMentions);
            $this->DispatchSync(new SyncOccupations);
        }

        foreach (config('scraping.organizations') as $key => $organization) 
        {
            foreach ($articlesDiff($key)->additions() as $externalArticle) 
            {
                $this->dispatchSync(new CreateArticle($externalArticle));
            }
        }
    }
}