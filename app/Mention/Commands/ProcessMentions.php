<?php

namespace App\Newspaper\Commands;

final class ProcessMentions
{
    public function __construct(
        private collection $mentions,
        private int $articleId,
    ) {}

    public function __invoke(): void
    {
        foreach ($this->mentions as $mention) 
        {
            $this->dispatchSync(new CreateMention($mention, $this->articleId));
            $this->dispatchSync(new LinkMentionArticle($mention));
            $this->dispatchSync(new LinkMentionEntity($mention));
            $this->dispatchSync(new LinkMentionOrganization($mention));
        }
    }
}