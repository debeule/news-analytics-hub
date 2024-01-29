<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Organization;

use App\Jobs\ScrapeArticlesListJob;


class ScrapeArticlesListController extends Controller
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
