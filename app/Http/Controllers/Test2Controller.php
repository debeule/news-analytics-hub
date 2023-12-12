<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Article;
use App\Jobs\ScrapeArticleJob;
use Illuminate\Support\Facades\Bus;
use App\Models\Log;


class Test2Controller extends Controller
{
    public function __invoke(Request $request)
    {
        Dispatch(new ScrapeArticleJob(1))->onqueue('scraping-article');
    }
}

