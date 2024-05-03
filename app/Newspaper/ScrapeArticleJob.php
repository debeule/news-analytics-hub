<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Models\Log;


class ScrapeArticleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function __construct(
        public string $scrapingUrl,
    )
    {}

    public function handle(): void
    {
        $url = "http://scraper:5000";
        $endpoint = "/api/article-scraper";

        $data = [
            'url' => $this->scrapingUrl,
        ];

        try 
        {
            $client = new Client();

            $response = $client->post($url . $endpoint, [
                'json' => $data,
            ]);
            
            if ($response->getStatusCode() !== 200) 
            {
                Log::create([
                    'log_level' => 'error',
                    'action' => 'ScrapeArticleJob ==> scraper',
                    'message' => 'Unexpected response: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
                ]);
            }
        } 
        
        catch (\Throwable $th) 
        {
            Log::create([
                'log_level' => "error",
                'action' => "ScrapeArticlesListJob ==> laravel",
                'message' => $th->getMessage(),
            ]);
        }
        
    }
}
