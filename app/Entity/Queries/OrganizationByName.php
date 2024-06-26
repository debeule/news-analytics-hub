<?php

declare(strict_types=1);

namespace App\Entity\Queries;

use App\Entity\Organization;
use App\Extensions\Eloquent\Scopes\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class OrganizationByName
{
    public function __construct(
        public HasName $hasName = new HasName(''),
    ) {}

    public function query(): Builder
    {
        return Organization::query()
            ->tap($this->hasName);
    }

    public function hasName(string $name): self
    {
        return new self(
            new HasName($name),
        );
    }

    public function get(): Organization
    {
        /** @var Organization */
        return $this->query()->firstOrFail();
    }

    public function find(): ?Organization
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