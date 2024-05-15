<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Imports\Values\DateTime;
use Illuminate\Database\Eloquent\Builder;

final class FromDateTime
{
    public function __construct(
        private DateTime $DateTime = new DateTime,
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query
            ->whereDate('article_created_at', '>=', $this->DateTime->toString());
    }
}