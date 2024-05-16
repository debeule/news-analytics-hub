<?php

declare(strict_types=1);

namespace App\Mention\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class ProcessMentions
{
    use DispatchesJobs;

    private int $articleId;

    public function __construct(
        private collection $mentions,
        private ArticleByTitle $articleByTitle = new ArticleByTitle,
    ) {
        $this->articleId = $this->articleByTitle->hasTitle($this->data->article->title)->get()->id;
    }

    public function __invoke(): void
    {
        foreach ($this->mentions as $mention) 
        {
            $this->dispatchSync(new CreateMention($mention));
        }
    }
}