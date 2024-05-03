<?php

declare(strict_types=1);

namespace App\Raw;

use App\Newspaper\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeArticlesList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $organizationId,
        private ScrapeArticlesListUrl $url = new ScrapeArticlesListUrl(),
    ) {}

    public function handle(): void
    {
        PostRequest::setup(
            (string) $this->url,
            ['organizationId' => $this->organizationId]
        )->execute();
        #TODO: should return array of article urls to scrape
    }
}