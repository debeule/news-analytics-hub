<?php

namespace App\Newspaper\Commands;

use App\OpenAi\Commands\ProcessData;
use App\Imports\Article as ExternalArticle;

final class ProcessBaseData
{
    public function __construct(
        public ExternalArticle $article,
        private ProcessData $processData,
    ){
        $this->processData = new ProcessData($this->article);
    }

    public function __invoke(): void
    {
        ProcessCategories::setup($this->data->categories)->execute();
        ProcessEntities::setup($this->data->entities)->execute();
        ProcessOrganizations::setup($this->data->organizations)->execute();
        ProcessOccupations::setup($this->data->occupations)->execute();

        ProcessArticles::setup($this->data->articles)->execute();
        
        ProcessMentions::setup($this->data->mentions)->execute();
    }
}