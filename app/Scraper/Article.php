<?php

declare(strict_types=1);

namespace App\Scraper;

use App\Imports\Dtos\Article as ArticleInterface;

class Article implements ArticleInterface
{
    public function __construct(
        public string $title,
        public string $url,
        public int $organizationId,
        public ?string $fullContent = null,
    ) {}
    
    public function title(): string
    {
        return $this->title;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function fullContent(): ?string
    {
        return $this->fullContent;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
