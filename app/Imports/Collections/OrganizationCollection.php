<?php
namespace App\Imports\Queries\Collections;

use Illuminate\Support\Collection;
use App\Entity\Organization;

class OrganizationCollection extends Collection
{
    public function offsetSet($key, $value)
    {
        if (!$value instanceof Organization) {
            throw new \InvalidArgumentException("Value must be an instance of Organization");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item)
    {
        if (!$item instanceof Organization) {
            throw new \InvalidArgumentException("Value must be an instance of Organization");
        }

        parent::add($item);
    }
}