<?php

declare(strict_types=1);

namespace App\Article\Queries;

use App\Article\Article;
use App\Extensions\Eloquent\Scopes\HasTitle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ArticleByTitle
{
    public function __construct(
        public HasTitle $hasTitle = new HasTitle(''),
    ) {}

    public function query(): Builder
    {
        return Article::query()
            ->tap($this->hasTitle);
    }

    public function hasTitle(string $name): self
    {
        return new self(
            new HasTitle($name),
        );
    }

    public function get(): Article
    {
        /** @var Article */
        return $this->query()->firstOrFail();
    }

    public function find(): ?Article
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