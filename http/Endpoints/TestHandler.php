<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;


class TestHandler
{
    public function __invoke(Request $request): void
    {
        $articles = Article::where('full_content', null)
        ->where('organization_id', 1)
        ->get();

        $batch = Bus::batch($articles)
        ->allowFailures()
        ->dispatch();

        
        dd($batch);
    }
    public function test(Request $request): void
    {
        Dispatch(new ScrapeArticleJob(1))->onqueue('scraping-article');
    }
}

