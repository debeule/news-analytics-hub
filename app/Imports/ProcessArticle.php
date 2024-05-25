<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\ProcessArticleDomain;
use App\Entity\Commands\ProcessEntityDomain;
use App\Imports\Dtos\Article as ExternalArticle;
use App\Mention\Commands\ProcessMentionDomain;
use App\OpenAi\Commands\CreateDataObject;
use App\OpenAi\Commands\ProcessData;
use App\Article\Article;

use App\OpenAi\Data;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Scraper\Commands\ScrapeArticle;
use App\Imports\Values\GuzzleResponse;
use App\Article\Queries\CacheFullContentByTitle;

class ProcessArticle implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $tries = 5;

    public function __construct(
        public ExternalArticle $article,
        public CacheFullContentByTitle $fullContentQuery = new CacheFullContentByTitle,
    ){
        $this->fullContentQuery = $this->fullContentQuery
            ->fromArticleTitle($this->article->title)
            ->fromOrganizationId($this->article->organizationId);
    }

    public function handle(): void
    {

        $data = $this->getData($this->article);

        $this->dispatchSync(new ProcessEntityDomain($data));
        $this->dispatchSync(new ProcessArticleDomain($data->article()));
        $this->dispatchSync(new ProcessMentionDomain($data));
    }

    public function getData(ExternalArticle $article): Data
    {
        $this->article->fullContent = $this->fullContentQuery->find();

        $processData = new ProcessData($this->article->fullContent);

        return CreateDataobject::fromArray($processData->get(), $this->article)->toDataObject();
    }
}