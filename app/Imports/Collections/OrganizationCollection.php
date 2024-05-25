<?php

declare(strict_types=1);
namespace App\Imports\Collections;

use App\Entity\Organization;
use Illuminate\Support\Collection;

class OrganizationCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (! $value instanceof Organization) {
            throw new \InvalidArgumentException("Value must be an instance of Organization");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item): void
    {
        if (! $item instanceof Organization) {
            throw new \InvalidArgumentException("Value must be an instance of Organization");
        }

        parent::add($item);
    }
}