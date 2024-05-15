<?php
namespace App\Imports\Queries\Collections;

use Illuminate\Support\Collection;
use App\Mention\Mention;

class MentionCollection extends Collection
{
    public function offsetSet($key, $value)
    {
        if (!$value instanceof Mention) {
            throw new \InvalidArgumentException("Value must be an instance of Mention");
        }

        parent::offsetSet($key, $value);
    }

    public function add($item)
    {
        if (!$item instanceof Mention) {
            throw new \InvalidArgumentException("Value must be an instance of Mention");
        }

        parent::add($item);
    }
}