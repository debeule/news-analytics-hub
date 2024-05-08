<?php

declare(strict_types=1);

namespace App\Scraper\Commands;

use App\Newspaper\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

use App\Imports\Values\ScrapeArticlesListEndpoint;
use App\Services\PostRequest;

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

    public function execute(): void
    {
        PostRequest::setup(
            (string) $this->endpoint,
            ['organizationId' => $this->organizationId]
        )->execute();
    }

    public function get(): Collection
    {
        $collection = collect();

        foreach($this->execute() as $listItem)
        {
            $externalArticle = new Article($listItem->title, $listItem->url, $listItem->organization_id);

            $collection->push(new Article($externalArticle));
        }

        return $collection;
    }
}