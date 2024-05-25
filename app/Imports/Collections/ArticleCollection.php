<?php

declare(strict_types=1);
namespace App\Imports\Collections;

use App\Imports\Dtos\ProcessedArticle;
use Illuminate\Support\Collection;

class ArticleCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (! $value instanceof ProcessedArticle) {
            throw new \InvalidArgumentException("Value must be an instance of ProcessedArticle");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item): collection
    {
        if (! $item instanceof ProcessedArticle) 
        {
            throw new \InvalidArgumentException("Value must be an instance of ProcessedArticle");
        }

        return parent::add($item);
    }
}