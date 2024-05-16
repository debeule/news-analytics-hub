<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

interface Organization
{
    public function name(): string;
    public function sector(): string;
}