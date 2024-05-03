<?php

declare(strict_types=1);

namespace Http\Endpoints;


use App\Jobs\ScrapeArticlesListJob;

use App\Models\Organization;


class ScrapeArticlesListHandler
{
    public function __invoke(): void
    {
        $newsOrganizations = Organization::where('organization_type', 'news_paper')->get();

        foreach ($newsOrganizations as $newsOrganization) 
        {            
            Dispatch(new ScrapeArticlesListJob($newsOrganization->id))->onqueue('scraping-articles-list');
        }
    }
}
