<?php

declare(strict_types=1);
namespace App\Imports\Collections;

use App\Mention\Mention;
use Illuminate\Support\Collection;

class MentionCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (! $value instanceof Mention) {
            throw new \InvalidArgumentException("Value must be an instance of Mention");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item): collection
    {
        if (! $item instanceof Mention) 
        {
            throw new \InvalidArgumentException("Value must be an instance of Mention");
        }

        return parent::add($item);
    }
}