<?php

declare(strict_types=1);

namespace App\Mention\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class ProcessMentions
{
    use DispatchesJobs;

    public function __construct(
        private collection $mentions,
        private int $articleId,
    ) {}

    public function __invoke(): void
    {
        foreach ($this->mentions as $mention) 
        {
            $this->dispatchSync(new CreateMention($mention, $this->articleId));
        }
    }
}