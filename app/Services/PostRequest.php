<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

final class PostRequest
{
    public function __construct(
        private string $url,
        private array $data,
        private Client $client = new Client()
    ) {}

    public static function setup(string $url, array $data): self
    {
        return new self($url, $data);
    }

    public function execute(): Object
    {
        try 
        {
            return $this->client->post($this->url, [
                'json' => $data,
            ]);
        } 
        
        catch (\Throwable $th) 
        {
            throw new Exception($th->getStatusCode() . ' - ' . $th->getMessage());
        }
    }
}