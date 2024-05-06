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
        private ScrapeArticleEndpoint $endpoint = new ScrapeArticleEndpoint(),
    ) {}

    public static function setup(string $url): self
    {
        return new self($url);
    }

    public function get(): void
    {
        PostRequest::setup(
            (string) $this->endpoint,
            ['url' => $this->scrapingUrl]
        )->execute();
    }
}
