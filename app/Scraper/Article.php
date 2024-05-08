<?php

declare(strict_types=1);

namespace App\Scraper;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\Article as ArticleInterface;

class Article implements ArticleInterface
{
    public function __construct(
        public string $title, 
        public string $url, 
        public ?string $fullContent = null,
        public int $organizationId
    ) {}
    
    public function title(): string
    {
        return $this->title;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function organization(): int
    {
        return Organization::find($this->organizationId);
    }

    public function fullContent(): string
    {
        return $this->fullContent;
    }
}
