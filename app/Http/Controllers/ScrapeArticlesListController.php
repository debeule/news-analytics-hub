<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ScrapeArticlesListJob;

class ScrapeArticlesListController extends Controller
{
    public function __invoke()
    {
        foreach (config("scraping.entities") as $entity) 
        {
            Dispatch(new ScrapeArticlesListJob(entity: $entity));
        }
    }
}
