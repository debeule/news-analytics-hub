<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

interface Mention 
{
    public function entity(): string;
    public function organization(): string;
    public function context(): string;
    public function sentiment(): int;
}