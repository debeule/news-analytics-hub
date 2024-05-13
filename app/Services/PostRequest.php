<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

final class PostRequest
{
    public function __construct(
        private string $url,
        private array $headers = [],
        private array $data,
        private Client $client = new Client()
    ) {}

    public static function setup(string $url, array $headers = [], array $data): self
    {
        return new self($url, $headers, $data);
    }

    public function execute(): Object
    {
        try 
        {
            return $this->client->post($this->url, [
                'headers' => $this->headers,
                'json' => $this->data,
            ]);
        } 
        
        catch (\Throwable $th) 
        {
            throw new Exception($th->getMessage());
        }
    }
}