<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Helpers\Helpers;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        ray("heh")->die();
        $baseCommand = 'scrapy crawl ArticleListScraper';
        $arg1 = '-a START_URLS="' . $this->entity . '"'; 
        $arg2 = '-a ALLOWED_DOMAINS="' . $this->entity . '"';

        $command = $baseCommand . ' ' . $arg1 . ' ' . $arg2;

        $articles = shell_exec($command);
    }
}
