<?php

namespace Http\Endpoints;

use Illuminate\Http\Request;

use App\Models\Organization;

use App\Jobs\ScrapeArticlesListJob;


class ScrapeArticlesListHandler
{
    public function __invoke()
    {
        $newsOrganizations = Organization::where('organization_type', 'news_paper')->get();

        foreach ($newsOrganizations as $newsOrganization) 
        {            
            Dispatch(new ScrapeArticlesListJob($newsOrganization->id))->onqueue('scraping-articles-list');
        }
    }
}
