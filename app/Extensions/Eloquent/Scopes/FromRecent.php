<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Imports\Values\Date;
use Illuminate\Database\Eloquent\Builder;

final class FromRecent
{
    public function __construct(
        private Date $date = new Date,
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query
            ->whereDate('article_created_at', '>=', $this->date->toString());
    }
}