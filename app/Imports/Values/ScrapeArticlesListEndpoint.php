<?php

declare(strict_types=1);

namespace App\Imports\Values;

use League\Uri\Uri;

final class ScrapeArticlesListEndpoint
{
    public string $value;

    public function __construct(
        private ScraperUrl $scrapeUrl = new ScraperUrl(),
        private string $endpoint = 'articles_list_scraper',
    ) {
        $this->value = (string) Uri::new((string) $this->scrapeUrl . $this->endpoint);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}