<?php

namespace App\Imports\Queries;

use App\Newspaper\Organization;

interface Article 
{
    public function title(): string;
    public function url(): string;
    public function fullContent(): ?string;
    public function organizationId(): int;
}