<?php

declare(strict_types=1);

namespace App\Mention\Commands;

use App\Article\Queries\ArticleByTitle;
use App\OpenAi\Data;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class ProcessMentionDomain
{
    use DispatchesJobs;

    private int $articleId;

    public function __construct(
        private Data $data,
        private ArticleByTitle $articleByTitle = new ArticleByTitle,
    ){
        $this->articleId = $this->articleByTitle->hasTitle($this->data->article()->title())->get()->id;
    }

    public function __invoke(): void
    {
        $this->dispatchSync(new ProcessMentions($this->data->mentions(), $this->articleId));
    }
}