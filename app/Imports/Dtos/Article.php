<?php

namespace App\Imports\Dtos;

use App\Entity\Organization;
use Carbon\CarbonImmutable;

interface Article 
{
    public function title(): string;
    public function url(): string;
    public function organizationId(): int;
    public function fullContent(): ?string;
    public function category(): ?string;
    public function createdAt(): ?CarbonImmutable;
}