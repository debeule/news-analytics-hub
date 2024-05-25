<?php

declare(strict_types=1);

namespace App\Article\Queries;

use App\Imports\Queries\ExternalArticles;
use App\Services\FilterAdditions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

class ArticlesDiff
{
    use DispatchesJobs;

    private Collection $allRecentArticles;
    private Collection $externalArticles;

    public function __construct(
        private ExternalArticles $externalArticlesQuery = new ExternalArticles,
        private ArticlesByOrganization $articlesQuery = new ArticlesByOrganization,
    ) {
    }

    public function __invoke(int $organizationId): self
    {
        $this->externalArticlesQuery->organizationId = $organizationId;
        $this->externalArticles = $this->externalArticlesQuery->get();

        $this->allRecentArticles = $this->articlesQuery->fromOrganizationId($organizationId)->FromDateTime(24)->get();

        return $this;
    }
    
    public function additions(): Collection
    {
        $filter = new FilterAdditions($this->allRecentArticles, $this->externalArticles, 'title');

        return $filter->handle();
    }
}
