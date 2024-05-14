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

        $this->dispatchSync(new CreateArticle($this->article, $data['response']));

        foreach ($data['organizations'] as $organization) 
        {
            $this->dispatchSync(new CreateOrganization($organization));
            $this->dispatchSync(new LinkOrganization($organization));
        }

        foreach ($data['entities'] as $entity) 
        {
            $this->dispatchSync(new CreateEntity($entity));
            $this->dispatchSync(new LinkEntity($entity));
        }

        foreach ($data['mentions'] as $mention) 
        {
            $this->dispatchSync(new CreateMention($mention));
            $this->dispatchSync(new LinkMention($mention));
        }
    }
}