<?php

namespace Http\Endpoints;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Article;
use App\Jobs\ScrapeArticlesListJob;
use Illuminate\Support\Facades\Bus;
use App\Models\Log;


class TestHandler
{
    public function __invoke(Request $request)
    {
        $articles = Article::where('full_content', null)
        ->where('organization_id', 1)
        ->get();

        $batch = Bus::batch($articles)
        ->allowFailures()
        ->dispatch();

        
        dd($batch);
    }
    public function test(Request $request)
    {
        Dispatch(new ScrapeArticleJob(1))->onqueue('scraping-article');
    }
}

