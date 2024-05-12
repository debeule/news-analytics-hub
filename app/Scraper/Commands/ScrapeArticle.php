<?php

declare(strict_types=1);

namespace App\Scraper\Commands;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Psr7\Response;

use App\Scraper\Article;
use App\Imports\Values\ScrapeArticleEndpoint;
use App\Services\PostRequest;

class ScrapeArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Article $article,
        private ScrapeArticleEndpoint $endpoint = new ScrapeArticleEndpoint(),
    ) {}

    public static function setup(Article $article): self
    {
        return new self($article);
    }

    public function execute(): Response
    {
        return PostRequest::setup(
            (string) $this->endpoint,
            [
                'organization_id' => $this->article->organizationId,
                'url' => $this->article->url,
            ]
        )->execute();
    }

    public function get(): Response
    {
        return $this->execute();
    }
}
