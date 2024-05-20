<?php

declare(strict_types=1);

namespace App\Scraper\Commands;

use App\Imports\Values\GuzzleResponse;
use App\Imports\Values\ScrapeArticlesListEndpoint;
use App\Scraper\Article;
use App\Services\PostRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Entity\Organization;

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

    public function execute()
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

        foreach($data['response'] as $listItem)
        {
            $externalArticle = new Article(
                $listItem['title'], 
                $listItem['url'], 
                #TODO: rework article into seperate scraper article / openai article
                Organization::find($this->organizationId)->name,
        );

            $externalArticles->push($externalArticle);
        }

        return $externalArticles;
    }
}