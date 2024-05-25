<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\ProcessArticleDomain;
use App\Entity\Commands\ProcessEntityDomain;
use App\Imports\Dtos\Article as ExternalArticle;
use App\Mention\Commands\ProcessMentionDomain;
use App\OpenAi\Commands\CreateDataObject;
use App\OpenAi\Commands\ProcessData;

use App\OpenAi\Data;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Scraper\Commands\ScrapeArticle;
use App\Imports\Values\GuzzleResponse;

class ProcessArticle implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $tries = 5;

    public function __construct(
        public ExternalArticle $article,
    ){}

    public function handle(): void
    {
        $this->article->fullContent = $this->scrapeArticleContent();

        $data = $this->getData();

        $this->dispatchSync(new ProcessEntityDomain($data));
        $this->dispatchSync(new ProcessArticleDomain($data->article()));
        $this->dispatchSync(new ProcessMentionDomain($data));
    }

    public function getData(): Data
    {
        $processData = new ProcessData($this->article->fullContent());

        return CreateDataobject::fromArray($processData->get(), $this->article)->toDataObject();
    }

    public function scrapeArticleContent(): string
    {
        $response = ScrapeArticle::setup($this->article)->get();
        $fullContent = GuzzleResponse::fromResponse($response)->extractScraperResponse();

        if ($fullContent == '') throw new \Exception('Failed to scrape article content');

        return $fullContent;
    }
}