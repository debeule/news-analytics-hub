<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

final class PostRequest
{
    public function __construct(
        private string $url,

        /** @var array<string> */
        private array $data,
        
        /** @var array<string> */
        private array $headers = [],
        private Client $client = new Client()
    ) {}

    /**  
     * @param array<mixed> $data
     * @param array<mixed> $headers
    */
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