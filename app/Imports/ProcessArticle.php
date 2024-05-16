<?php

namespace App\Imports;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\OpenAi\Commands\ProcessData;
use App\OpenAi\Commands\CreateDataObject;
use App\Imports\Dtos\Article as ExternalArticle;
use App\Article\Commands\ProcessArticleDomain;
use App\Entity\Commands\ProcessEntityDomain;
use App\Mention\Commands\ProcessMentionDomain;
use App\OpenAi\Data;
use App\Article\Article;

class ProcessArticle implements ShouldQueue
{
    use DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public ProcessData $processData;

    public function __construct(
        public ExternalArticle $article,
    ){
        $this->processData = new ProcessData($this->article->fullContent());
    }

    public function handle(): void
    {
        $data = $this->getData();

        $this->dispatchSync(new ProcessEntityDomain($data));
        $this->dispatchSync(new ProcessArticleDomain($data->article()));
        $this->dispatchSync(new ProcessMentionDomain($data));
    }

    public function getData(): Data
    {
        return CreateDataobject::fromArray($this->processData->get(), $this->article)->toDataObject();
    }
}