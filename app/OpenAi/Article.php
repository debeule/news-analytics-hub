<?php

declare(strict_types=1);

namespace App\OpenAi;

use App\Imports\Dtos\ProcessedArticle as ArticleInterface;
use App\Imports\Values\DateTime;
use Carbon\CarbonImmutable;

class Article implements ArticleInterface
{
    public function __construct(
        public string $title,
        public string $url,
        public string $fullContent,
        public int $organizationId,
        public ?string $category = null,
        public ?string $author = null,
        public ?string $createdAt = null,
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

    public function category(): ?string
    {
        return $this->category;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }

    public function author(): ?string
    {
        return $this->author;
    }

    public function createdAt(): ?CarbonImmutable
    {
        if(is_null($this->createdAt)) return null;

        return DateTime::fromString($this->createdAt)->toCarbonImmutable();
    }
}
