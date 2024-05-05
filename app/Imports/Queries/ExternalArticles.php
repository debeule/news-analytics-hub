<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use Illuminate\Support\Collection;

interface ExternalSports
{
    public function get(): Collection;
}
