<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;

final class HasId
{
    public function __construct(
        private int $value,
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query->where('id', $this->value);
    }
}