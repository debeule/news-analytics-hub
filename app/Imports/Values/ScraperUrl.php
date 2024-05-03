<?php

declare(strict_types=1);

namespace App\Imports\Values;

use League\Uri\Uri;

final class ScraperUrl
{
    public string $value;

    public function __construct(
        private string $path = 'http://scraper:5000',
        private string $suffix = '/api/'
    ) {
        $this->value = (string) Uri::new($this->path . $this->suffix);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}