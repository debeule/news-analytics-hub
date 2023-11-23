<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        $changeDirCommand = "cd " . config("scraping.destination");
        
        $enableVenvCommand = config("scraping.enableVenvCommand");

        $scrapyCommand = 'scrapy crawl ArticleListScraper -a provider=' . $request->provider;

        $combinedCommand = $changeDirCommand . " && " . $enableVenvCommand . " && " . $scrapyCommand;
        

        try 
        {
            shell_exec($combinedCommand);
        } 
        catch (\Exception $e) 
        {
            DB::table('logs')->insert([
                'log_level' => 'error',
                'message' => $e->getMessage(),
                'failed_action' => $combinedCommand,
            ]);
        }
    }
}

