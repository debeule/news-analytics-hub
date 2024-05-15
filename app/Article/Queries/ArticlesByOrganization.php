<?php

namespace App\Article\Queries;

use App\Article\Article;
use App\Extensions\Eloquent\Scopes\HasOrganizationId;
use App\Extensions\Eloquent\Scopes\FromDateTime;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Values\DateTime;
use Illuminate\Support\Collection;

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

    public function FromDateTime(int $amountOfHours): self
    {
        return new self(
            $this->hasOrganizationId,
            new FromDateTime(DateTime::fromHoursAgo($amountOfHours)),
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