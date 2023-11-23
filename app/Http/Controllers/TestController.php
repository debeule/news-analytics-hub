<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        $changeDirCommand = "cd " . config("scraping.destination");
        $enableVenvCommand = "source ./venv/Scripts/activate";

        $scrapyCommand = 'scrapy crawl ArticleListScraper -a organization_id=' . "1";

        $combinedCommand = $changeDirCommand . " && " . $enableVenvCommand . " && " . $scrapyCommand;
        
        dd($combinedCommand);
        

        try 
        {
            dd($combinedCommand);
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

