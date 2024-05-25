<?php

declare(strict_types=1);

namespace App\Article\Queries;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CacheFullContentByTitle
{
    public function __construct(
        public string $articleTitle = '',
        public int $organizationId = 0,
    ) {}

    public function query(): string
    {
        return Cache::get('article_full_content_' . $this->organizationId . '_' . $this->articleTitle);
    }

    public function fromArticleTitle(string $articleTitle): self
    {
        return new self(
            $articleTitle,
            $this->organizationId,
        );
    }

    public function fromOrganizationId(int $organizationId): self
    {
        return new self(
            $this->articleTitle,
            $organizationId,
        );
    }

    public function get(): string
    {
        return $this->query();
    }

    public function find(): ?string
    {
        try 
        {
            return $this->get();
        } 
        catch (ModelNotFoundException) 
        {
            return null;
        }
    }
}