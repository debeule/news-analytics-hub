<?php

namespace App\Article\Commands;

use App\Imports\Article as ExternalArticle;

final class ProcessArticleDomain
{
    public function __invoke(ExternalArticle $article): void
    {
        $this->dispatchSync(new CreateArticle($article));
    }
}