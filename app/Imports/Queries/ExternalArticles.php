<?php

namespace App\Imports\Queries;

use Illuminate\Support\Collection;

interface ExternalArticles
{
    public function get(): collection;
}