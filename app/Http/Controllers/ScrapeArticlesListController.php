<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
