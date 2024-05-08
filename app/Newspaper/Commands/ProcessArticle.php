<?php

namespace App\Newspaper\Commands;

use App\OpenAi\Commands\ProcessData;
use App\Imports\Article as ExternalArticle;

final class ProcessBaseData
{
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