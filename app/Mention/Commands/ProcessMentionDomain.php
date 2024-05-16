<?php

declare(strict_types=1);

namespace App\Mention\Commands;

use App\OpenAI\Data;

final class ProcessMentionDomain
{
    public function __construct(
        private Data $data,
    ){}

    public function __invoke(): void
    {
        $this->dispatchSync(new ProcessMentions($this->data->mentions, $this->articleId));
    }
}