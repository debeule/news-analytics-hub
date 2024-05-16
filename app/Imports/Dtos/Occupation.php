<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

interface Occupation 
{
    public function name(): string;
    public function sector(): string;
}