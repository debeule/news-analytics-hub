<?php

declare(strict_types=1);

namespace App\Imports\Values;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

final class Response
{
    private string $value;

    public function __construct(
        private GuzzleResponse $response,
    ) {
        $this->value = $this->getContents($this->response);
    }

    public static function fromResponse(GuzzleResponse $response): self
    {
        return new self($response);
    }

    private function getContents(GuzzleResponse $response)
    {
        return $response->getBody()->getContents();
    }

    private function decode()
    {
        return json_decode($this->value, true);
    }

    public function getData()
    {
        return $this->decode();
    }
}