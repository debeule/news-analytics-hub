<?php

namespace App\Newspaper;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Jobs\ScrapeArticleJob;
use App\Models\Organization;
use App\Models\Log;
use App\Models\Article;


class ScrapeArticlesListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $organizationId)
    {}

    public function handle(): void
    {
        $url = "http://scraper:5000";
        $endpoint = "/api/articles_list_scraper";

        $data = [
            'organizationId' => $this->organizationId,
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
                    'action' => 'ScrapeArticlesListJob ==> scraper',
                    'message' => 'Unexpected response: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
                ]);
            }
        } 
        
        catch (\Throwable $th) 
        {
            Log::create([
                'log_level' => "error",
                'action' => "ScrapeArticlesListJob ==> laravel",
                'message' => 'Unexpected response: ' . $th->getMessage(),
            ]);
        }
    }
}