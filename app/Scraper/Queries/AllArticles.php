<?php

namespace App\Scraper\Queries;

use App\Imports\Queries\ExternalArticles;
use Illuminate\Support\Collection;
use App\Scraper\Commands\ScrapeArticlesList;
use App\Scraper\Article;

final class AllArticles implements ExternalArticles
{
    public function __construct(
        public int $organizationId = 0,
    ) {}

    public static function setup(int $organizationId): self
    {
        return new self($organizationId);
    }

    public function scrapeArticles(): Collection
    {
        $scraperArticles = collect();

        $articles = ScrapeArticlesList::setup($this->organizationId)->get();

        foreach ($articles as $article) 
        {
            $article->fullContent = ScrapeArticle::setup($article->url())->get();
        }

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