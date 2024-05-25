<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\CacheFullContentByTitle;

use App\Imports\Dtos\Article as ExternalArticle;
use App\Imports\Values\GuzzleResponse;
use App\Scraper\Commands\ScrapeArticle as ScrapeArticleCommand;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeArticle implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /** @var int */
    public $tries = 4;

    public function __construct(
        public ExternalArticle $article,
    ){}

    public function handle(): void
    {
        $this->article->fullContent = $this->scrapeArticleContent();
        
        CacheFullContentByTitle::setup($this->article, $this->article->fullContent)->execute();
    }

    public function scrapeArticleContent(): string
    {
        $response = ScrapeArticleCommand::setup($this->article)->get();
        $fullContent = GuzzleResponse::fromResponse($response)->extractScraperResponse();

        if ($fullContent == '') throw new \Exception('Failed to scrape article content');

        return $fullContent;
    }
}