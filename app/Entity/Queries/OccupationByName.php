<?php

declare(strict_types=1);

namespace App\Entity\Queries;

use App\Entity\Occupation;
use App\Extensions\Eloquent\Scopes\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class OccupationByName
{
    public function __construct(
        public HasName $hasName = new HasName(''),
    ) {}

    public function query(): Builder
    {
        return Occupation::query()
            ->tap($this->hasName);
    }

    public function hasName(string $name): self
    {
        return new self(
            new HasName($name),
        );
    }

    public function get(): Occupation
    {
        /** @var Occupation */
        return $this->query()->firstOrFail();
    }

    public function find(): ?Occupation
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