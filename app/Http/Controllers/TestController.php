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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        $source = "https://" . "www.praxistraining.be/opleidingen/opleiding/273-scraper";
        $argument = '-a scrape_url="' . $source . '"'; 

        $scrapyCommand = 'scrapy crawl ArticleListScraper' . ' ' . $argument;

        $changeDirCommand = "cd " . config("scraping.destination");

        $response = shell_exec($changeDirCommand . " && " . $scrapyCommand);
        
        ray($response)->die();


        // foreach (config("scraping.sources") as $source) 
        // {
        //     $baseCommand = 'scrapy runspider ArticleListScraper';
        //     $arg1 = '-a scrape_url="' . $source["domain"] . '"'; 
    
        //     $command = $baseCommand . ' ' . $arg1 . ' ' . $arg2;
            
        //     ray(shell_exec($command))->die();
        //     $articles = shell_exec($command);
        // }
    }
}

