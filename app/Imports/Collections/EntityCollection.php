<?php

declare(strict_types=1);
namespace App\Imports\Queries\Collections;

use App\Entity\Entity;
use Illuminate\Support\Collection;

class EntityCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (! $value instanceof Entity) {
            throw new \InvalidArgumentException("Value must be an instance of Entity");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item): void
    {
        if (! $item instanceof Entity) {
            throw new \InvalidArgumentException("Value must be an instance of Entity");
        }

        parent::add($item);
    }
}