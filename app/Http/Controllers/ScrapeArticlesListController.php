<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Organization;

use App\Jobs\ScrapeArticlesListJob;


class ScrapeArticlesListController extends Controller
{
    public function __invoke()
    {
        foreach (config("scraping.organizations") as $organization) 
        {
            $organization = Organization::where('name', $organization["name"])->first();
            
            Dispatch(new ScrapeArticlesListJob($organization->id));
        }
    }
}
