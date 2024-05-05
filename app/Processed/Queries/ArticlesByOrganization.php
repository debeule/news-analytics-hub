<?php

namespace App\Processed\Queries;

final class AllRecentArticles
{
    public function __construct(
        public HasOrganizationId $hasOrganizationId = new HasOrganizationId,
        public FromRecent $fromRecent = new FromRecent,
    ) {}

    public function query(): Builder
    {
        return Sport::query()
            ->tap($this->hasOrganizationName);
    }

    public function fromOrganizationId(int $organizationId): self
    {
        return new self(
            new HasOrganizationId($organizationId),
            $this->fromRecent,
        );
    }

    public function fromRecent(int $amountOfHours): self
    {
        return new self(
            $this->hasOrganizationId,
            new FromRecent(Datetime::fromHoursAgo($amountOfHours)),
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