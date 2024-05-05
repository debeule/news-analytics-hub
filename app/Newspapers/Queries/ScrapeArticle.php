<?php

declare(strict_types=1);

namespace App\Raw;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $scrapingUrl,
        private ScrapeArticleUrl $url = new ScrapeArticleUrl(),
    ) {}

    public function handle(): void
    {
        PostRequest::setup(
            (string) $this->url,
            ['organizationId' => $this->scrapingUrl]
        )->execute();
        #TODO: should return full content of article
    }
}
