<?php

namespace App\Newspaper\Commands;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\OpenAi\Commands\ProcessData;
use App\Imports\Queries\Article as ExternalArticle;

final class ProcessArticle implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ExternalArticle $article,
    ){}

    public function __invoke(): void
    {
        $data = ProcessData::setup($this->article->fullContent)->execute();

        ProcessCategories::setup($data->categories)->execute();
        ProcessEntities::setup($data->entities)->execute();
        ProcessOrganizations::setup($data->organizations)->execute();
        ProcessOccupations::setup($data->occupations)->execute();

        ProcessArticles::setup($data->articles)->execute();
        
        ProcessMentions::setup($data->mentions)->execute();
    }
}