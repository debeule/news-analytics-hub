<?php

declare(strict_types=1);

namespace App\Entity\Queries;

use App\Entity\Organization;
use App\Extensions\Eloquent\Scopes\HasId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class OrganizationById
{
    public function __construct(
        public HasId $hasId = new HasId(''),
    ) {}

    public function query(): Builder
    {
        return Organization::query()
            ->tap($this->hasId);
    }

    public function hasId(int $id): self
    {
        return new self(
            new HasId($id),
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