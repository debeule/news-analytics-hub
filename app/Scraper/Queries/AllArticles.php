<?php

declare(strict_types=1);

namespace App\Scraper\Queries;

use App\Imports\Queries\ExternalArticles;
use App\Imports\Values\GuzzleResponse;
use App\Scraper\Commands\ScrapeArticle;
use App\Scraper\Commands\ScrapeArticlesList;
use Illuminate\Support\Collection;

final class AllArticles implements ExternalArticles
{
    public function __construct(
        public int $organizationId = 0,
    ) {}

    private function scrapeArticles(): Collection
    {
        $scraperArticles = collect();

        $articles = ScrapeArticlesList::setup($this->organizationId)->get();

        return $articles;
    }

    public function get(): Collection
    {
        return $this->scrapeArticles();
    }

    public function find(): ?Collection
    {
        try 
        {
            return $this->get();
        } 
        catch (\Throwable $th) 
        {
            throw $th;
        }
    }
}