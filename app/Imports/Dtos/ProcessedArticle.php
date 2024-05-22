<?php

declare(strict_types=1);

namespace App\Imports\Dtos;

use Carbon\CarbonImmutable;

interface ProcessedArticle 
{
    public function title(): string;
    public function url(): string;
    public function fullContent(): ?string;
    public function category(): ?string;
    public function organizationId(): int;
    public function author(): ?string;
    public function createdAt(): ?CarbonImmutable;
}