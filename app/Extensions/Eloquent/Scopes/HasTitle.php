<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;

final class HasTitle
{
    public function __construct(
        private string $value = '',
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query->where('title', '=', $this->value);
    }
}