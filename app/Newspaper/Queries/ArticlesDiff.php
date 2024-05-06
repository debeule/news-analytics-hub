<?php

namespace App\Newspaper\Queries;

use App\Imports\Queries\ExternalArticles;
use App\Services\FilterAdditions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class ArticlesDiff
{
    use DispatchesJobs;

    private Collection $allRecentArticles;
    private Collection $externalArticles;

    public function __construct(
        private ArticlesByOrganization $articlesQuery = new ArticlesByOrganization,
        private ExternalArticles $externalArticlesQuery,
    ) {
        $this->allRecentArticles = $this->articlesQuery->FromDatetime(24)->get();
    }

    public function __invoke(int $organizationId)
    {
        $this->externalArticlesQuery->organizationId = $organizationId;
        $this->externalArticles = $this->externalArticlesQuery->get();
    }
    
    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allRecentArticles, $this->externalArticles));
    }
}
