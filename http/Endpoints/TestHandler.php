<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Imports\SyncAllDomains;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestHandler
{
    use DispatchesJobs;
    
    public function __invoke()
    {
        $this->dispatchSync(new SyncAllDomains);
    }

    public function test2(Request $request): void
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

