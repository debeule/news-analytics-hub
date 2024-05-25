<?php

declare(strict_types=1);

namespace App\Imports\Values;

use GuzzleHttp\Psr7\Response;

final class GuzzleResponse
{
    private string $value;

    public function __construct(
        private Response $response,
    ) {
        $this->value = $this->getContents($this->response);
    }

    public static function fromResponse(Response $response): self
    {
        return new self($response);
    }

    private function getContents(Response $response): string
    {
        return $response->getBody()->getContents();
    }

    
    /** @return array<mixed> */
    private function decode(): array
    {
        return json_decode($this->value, true);
    }

    /** @return array<mixed> */
    public function getData(): array
    {
        return $this->decode();
    }

    public function extractScraperResponse(): string
    {
        return $this->getData()['response'][0]['result'];
    }

    /** @return array<mixed> */
    public function extractOpenAiResponse(): array
    {
        $contents = $this->getData()['choices'][0]['message']['content'];
        
        return json_decode($contents, true);
    }
}