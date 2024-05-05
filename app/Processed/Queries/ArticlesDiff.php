<?php

namespace App\Newspapers\Queries;

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
        private ArticlesByOrganization $articlesQuery = new AllRecentArticles,
        private ?ExternalArticles $externalArticlesQuery = null,
    ) {
        $this->allRecentArticles = $this->articlesQuery->fromOrganizationId($id)->fromRecent(24)->get();
        $this->externalArticles = $this->externalArticlesQuery->get();
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allSports, $this->externalSports));
    }
}

//scrape articles

//send to serice => check if exists = delete => return

//foreach insert
