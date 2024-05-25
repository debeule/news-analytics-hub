<?php

declare(strict_types=1);

namespace App\Article\Queries;

use App\Article\Article;
use App\Extensions\Eloquent\Scopes\FromDateTime;
use App\Extensions\Eloquent\Scopes\HasOrganizationId;
use App\Imports\Values\DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticlesByOrganization
{
    public function __construct(
        public HasOrganizationId $hasOrganizationId = new HasOrganizationId,
        public FromDateTime $FromDateTime = new FromDateTime,
    ) {}

    public function query(): Builder
    {
        return Article::query()
            ->tap($this->hasOrganizationId)
            ->when($this->FromDateTime, $this->FromDateTime);
    }

    public function fromOrganizationId(int $organizationId): self
    {
        return new self(
            new HasOrganizationId($organizationId),
            $this->FromDateTime,
        );
    }

    public function FromDateTime(int $amountOfDays): self
    {
        return new self(
            $this->hasOrganizationId,
            new FromDateTime(DateTime::fromDaysAgo($amountOfDays)),
        );
    }

    public function get(): Collection
    {
        return $this->query()->get();
    }

    public function find(): ?Collection
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