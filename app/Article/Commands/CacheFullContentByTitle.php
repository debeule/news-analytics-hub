<?php

declare(strict_types=1);

namespace App\Article\Commands;

use App\Imports\Dtos\Article as ExternalArticle;
use Illuminate\Support\Facades\Cache;

class CacheFullContentByTitle
{
    public function __construct(
        public string $articleTitle = '',
        public int $organizationId = 0,
        public string $fullContent = '',
    ) {}

    public static function setup(ExternalArticle $article, string $fullContent): self
    {
        return new self(
            $article->title,
            $article->organizationId,
            $fullContent,
        );
    }

    public function CacheData(): void
    {
        Cache::put('article_full_content_' . $this->organizationId . '_' . $this->articleTitle, $this->fullContent, now())->addMinutes(30);
    }

    public function execute(): void
    {
        $this->CacheData();
    }
}