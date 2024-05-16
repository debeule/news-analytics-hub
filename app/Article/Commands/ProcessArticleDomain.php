<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Imports\Article as ExternalArticle;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class ProcessArticleDomain
{
    use DispatchesJobs;

    public function __invoke(ExternalArticle $article): void
    {
        $this->dispatchSync(new CreateArticle($article));
    }
}