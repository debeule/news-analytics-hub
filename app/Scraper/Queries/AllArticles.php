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
            $data = GuzzleResponse::fromResponse($response)->getData();
            
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