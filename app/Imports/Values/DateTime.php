<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;

final class DateTime
{
    public string $value;

    public function __construct(
        CarbonImmutable $carbonImmutable = new CarbonImmutable(),
    ) {
        $this->value = $carbonImmutable->toDateString();
    }

    public static function fromString(string $input): self
    {
        return new self(CarbonImmutable::parse($input));
    }

    public static function fromDaysAgo(int $days): self
    {
        return new self(CarbonImmutable::today()->subDays($days));
    }

    public static function fromHoursAgo(int $hours): self
    {
        return new self(CarbonImmutable::today()->subHours($hours));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toCarbonImmutable(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->value);
    }

    public static function now(): self
    {
        return new self();
    }
}