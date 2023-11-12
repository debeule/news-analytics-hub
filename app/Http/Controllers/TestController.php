<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        $changeDirCommand = "cd " . config("scraping.destination");
        
        $enableVenvCommand = " .\\venv\\Scripts\\activate"; // source for linux

        $source = "https://" . "www.praxistraining.be/opleidingen/opleiding/273-scraper";
        $argument = '-a scrape_url="' . $source . '"'; 
        $scrapyCommand = 'scrapy crawl ArticleListScraper' . ' ' . $argument;


        $command = $changeDirCommand . " && " . $enableVenvCommand . " && " . $scrapyCommand . "2>&1";
        $response = shell_exec($command);


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

