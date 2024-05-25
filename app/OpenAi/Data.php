<?php

declare(strict_types=1);

namespace App\OpenAi;

use App\Imports\Dtos\Data as DataInterface;

use App\Imports\Dtos\ProcessedArticle as Article;
use App\Imports\Collections\EntityCollection;
use App\Imports\Collections\MentionCollection;
use App\Imports\Collections\OccupationCollection;
use App\Imports\Collections\OrganizationCollection;
use Illuminate\Support\Collection;

class Data implements DataInterface
{
    public function __construct(
        public Article $article,
        public ?collection $occupations,
        public ?Collection $organizations,
        public ?Collection $entities,
        public Collection $mentions,
    ) {}

    
    public function article(): Article
    {
        return $this->article;
    }
    
    public function occupations(): OccupationCollection
    {
        return $this->occupations;
    }

    public function organizations(): OrganizationCollection
    {
        return $this->organizations;
    }

    public function entities(): EntityCollection
    {
        return $this->entities;
    }

    public function mentions(): MentionCollection
    {
        return $this->mentions;
    }
}