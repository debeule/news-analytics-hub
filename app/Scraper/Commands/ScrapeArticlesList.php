<?php

declare(strict_types=1);

namespace App\Scraper\Commands;

use App\Imports\Values\GuzzleResponse;
use App\Imports\Values\ScrapeArticlesListEndpoint;
use App\Scraper\Article;
use App\Services\PostRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ScrapeArticlesList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $organizationId,
        private ScrapeArticlesListEndpoint $endpoint = new ScrapeArticlesListEndpoint(),
    ) {}

    public static function setup(int $organizationId): self
    {
        return new self($organizationId);
    }

    public function execute(): Response
    {
        return PostRequest::setup(
            (string) $this->endpoint,
            ['organization_id' => $this->organizationId]
        )->execute();
    }   

    public function get(): Collection
    {
        $response = $this->execute();
        $data = GuzzleResponse::fromResponse($response)->getData();

        $externalArticles = collect();

        foreach($data['response'] as $article)
        {
            $externalArticles->push(
                new Article(
                    $article['title'],
                    $article['url'],
                    $this->organizationId
                )
            );
        }

        return $externalArticles;
    }
}