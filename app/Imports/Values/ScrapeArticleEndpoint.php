<?php

declare(strict_types=1);

namespace App\Imports\Values;

use League\Uri\Uri;

final class ScrapeArticleEndpoint
{
    public string $value;

    public function __construct(
        private ScrapeUrl $scrapeUrl = new ScrapeUrl(),
        private string $endpoint = 'article_scraper',
    ) {
        $this->value = (string) Uri::new((string) $this->scrapeUrl . $this->endpoint);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}