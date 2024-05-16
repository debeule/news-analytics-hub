<?php

declare(strict_types=1);

namespace App\Entity\Queries;

use App\Extensions\Eloquent\Scopes\HasName;
use App\Entity\Entity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class EntityByName
{
    public function __construct(
        public HasName $hasName = new HasName(''),
    ) {}

    public function query(): Builder
    {
        return Entity::query()
            ->tap($this->hasName);
    }

    public function hasName(string $name): self
    {
        return new self(
            new HasName($name),
        );
    }

    public function get(): Entity
    {
        /** @var Entity */
        return $this->query()->firstOrFail();
    }

    public function find(): ?Entity
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