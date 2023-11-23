<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ScrapeArticlesListJob;
use App\Models\Organization;

class ScrapeArticlesListController extends Controller
{
    public function __invoke()
    {
        foreach (config("scraping.organizations") as $organization) 
        {
            $organizationId = Organization::where('name', $organization)->first();
            Dispatch(new ScrapeArticlesListJob($organizationId));
        }
    }
}
