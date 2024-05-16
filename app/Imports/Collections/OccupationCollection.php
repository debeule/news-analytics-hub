<?php

declare(strict_types=1);
namespace App\Imports\Queries\Collections;

use App\Entity\Occupation;
use Illuminate\Support\Collection;

class OccupationCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (! $value instanceof Occupation) {
            throw new \InvalidArgumentException("Value must be an instance of Occupation");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item): void
    {
        if (! $item instanceof Occupation) {
            throw new \InvalidArgumentException("Value must be an instance of Occupation");
        }

        parent::add($item);
    }
}