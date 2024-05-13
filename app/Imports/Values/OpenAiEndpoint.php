<?php

declare(strict_types=1);

namespace App\Imports\Values;

use League\Uri\Uri;

final class OpenAiEndpoint
{
    public string $value;

    public function __construct(
        private string $baseUrl = 'https://api.openai.com',
        private string $endpoint = '/v1/chat/completions',
    ) {
        $this->value = (string) Uri::new((string) $this->baseUrl . $this->endpoint);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}