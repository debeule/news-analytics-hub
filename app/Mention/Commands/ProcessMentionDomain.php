<?php

namespace App\Mention\Commands;

use App\Imports\Mention as ExternalMention;

final class ProcessMentionDomain
{
    public function __construct(
        private Collection $data,
        private int $articleId,
    ){}

    public function __invoke(): void
    {
        $this->dispatchSync(new ProcessMentions($this->data->mentions, $this->articleId));
    }
}