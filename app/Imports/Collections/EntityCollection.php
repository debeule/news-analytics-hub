<?php
namespace App\Imports\Queries\Collections;

use Illuminate\Support\Collection;
use App\Entity\Entity;

class EntityCollection extends Collection
{
    public function offsetSet($key, $value)
    {
        if (!$value instanceof Entity) {
            throw new \InvalidArgumentException("Value must be an instance of Entity");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item)
    {
        if (!$item instanceof Entity) {
            throw new \InvalidArgumentException("Value must be an instance of Entity");
        }

        parent::add($item);
    }
}