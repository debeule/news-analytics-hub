<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeArticlesListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $entity
    )
    {}

    public function handle(): void
    {
        $changeDirCommand = "cd " . config("scraping.destination");
        
        $enableVenvCommand = " .\\venv\\Scripts\\activate"; // source for linux

        $source = "https://" . "www.praxistraining.be/opleidingen/opleiding/273-scraper";
        $argument = '-a scrape_url="' . $source . '"'; 
        $scrapyCommand = 'scrapy crawl ArticleListScraper' . ' ' . $argument;


        $command = $changeDirCommand . " && " . $enableVenvCommand . " && " . $scrapyCommand . "2>&1";
        $response = shell_exec($command);

        foreach ($articles as $article) 
        {
            Dispatch(new ScrapeArticleJob($article));
        }
    }
}
