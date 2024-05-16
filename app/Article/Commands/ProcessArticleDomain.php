<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Imports\Dtos\Article as ExternalArticle;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class ProcessArticleDomain
{
    use DispatchesJobs;

    public function __construct(
        private ExternalArticle $article,
    ) {}

    public function __invoke(): void
    {
        $this->dispatchSync(new CreateArticle($this->article));
    }
}