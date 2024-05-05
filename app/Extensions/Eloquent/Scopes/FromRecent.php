<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Imports\Values\Datetime;
use Illuminate\Database\Eloquent\Builder;

final class FromRecent
{
    public function __construct(
        private Datetime $Datetime = new Datetime,
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query
            ->whereDatetime('article_created_at', '>=', $this->Datetime->toString());
    }
}