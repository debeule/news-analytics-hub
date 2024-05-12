<?php

namespace App\Newspaper\Queries;

use App\Newspaper\Article;
use App\Extensions\Eloquent\Scopes\HasOrganizationId;
use App\Extensions\Eloquent\Scopes\FromDatetime;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Values\Datetime;
use Illuminate\Support\Collection;

class ArticlesByOrganization
{
    public function __construct(
        public HasOrganizationId $hasOrganizationId = new HasOrganizationId,
        public FromDatetime $FromDatetime = new FromDatetime,
    ) {}

    public function query(): Builder
    {
        return Article::query()
            ->tap($this->hasOrganizationId)
            ->when($this->FromDatetime, $this->FromDatetime);
    }

    public function fromOrganizationId(int $organizationId): self
    {
        return new self(
            new HasOrganizationId($organizationId),
            $this->FromDatetime,
        );
    }

    public function FromDatetime(int $amountOfHours): self
    {
        return new self(
            $this->hasOrganizationId,
            new FromDatetime(Datetime::fromHoursAgo($amountOfHours)),
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