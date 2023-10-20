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
        $baseCommand = 'scrapy crawl ArticleListScraper';
        $arg1 = '-a START_URLS="' . $this->entity . '"'; 
        $arg2 = '-a ALLOWED_DOMAINS="' . $this->entity . '"';

        $command = $baseCommand . ' ' . $arg1 . ' ' . $arg2;

        $articles = shell_exec($command);

        foreach ($articles as $article) 
        {
            Dispatch(new ScrapeArticleJob($article));
        }
    }
}
