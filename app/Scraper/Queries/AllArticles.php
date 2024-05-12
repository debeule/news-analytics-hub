<?php

namespace App\Scraper\Queries;

use App\Imports\Queries\ExternalArticles;
use Illuminate\Support\Collection;
use App\Scraper\Commands\ScrapeArticlesList;
use App\Scraper\Commands\ScrapeArticle;
use App\Scraper\Article;
use App\Imports\Values\Response;

final class AllArticles implements ExternalArticles
{
    public function __construct(
        public int $organizationId = 0,
    ) {}

    public static function setup(int $organizationId): self
    {
        return new self($organizationId);
    }

    private function scrapeArticle(): Collection
    {
        $scraperArticles = collect();

        $articles = ScrapeArticlesList::setup($this->organizationId)->get();

        foreach ($articles as $article) 
        {
            $response = ScrapeArticle::setup($article)->get();
            $data = Response::fromResponse($response)->getData();
            
            $article->fullContent = $data['response'][0]['result'];

            #TODO: remove break when not debugging
            break;
        }

        return $articles;
    }

    public function get(): Collection
    {
        return $this->scrapeArticle();
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