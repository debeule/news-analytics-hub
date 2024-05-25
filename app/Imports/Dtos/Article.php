<?php

declare(strict_types=1);

namespace App\Imports\Dtos;


interface Article 
{
    public function title(): string;
    public function url(): string;
    public function fullContent(): ?string;
    public function organizationId(): int;
}