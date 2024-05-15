<?php
namespace App\Imports\Queries\Collections;

use Illuminate\Support\Collection;
use App\Entity\Occupation;

class OccupationCollection extends Collection
{
    public function offsetSet($key, $value)
    {
        if (!$value instanceof Occupation) {
            throw new \InvalidArgumentException("Value must be an instance of Occupation");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item)
    {
        if (!$item instanceof Occupation) {
            throw new \InvalidArgumentException("Value must be an instance of Occupation");
        }

        parent::add($item);
    }
}