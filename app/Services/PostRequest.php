<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

final class PostRequest
{
    public function __construct(
        private string $url,
        private array $data,
        private array $headers = [],
        private Client $client = new Client()
    ) {}

    public static function setup(string $url, array $data, array $headers = []): self
    {
        return new self($url, $data, $headers);
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