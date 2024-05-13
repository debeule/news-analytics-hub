<?php

namespace App\OpenAi\Commands;

use App\Newspaper\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;

use App\Imports\Values\OpenAiEndpoint;
use App\Services\PostRequest;

class ProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $fullContent,
        private OpenAiEndpoint $endpoint = new OpenAiEndpoint(),
        private Client $client = new Client(),
    ) {}

    public static function setup(string $fullContent): self
    {
        return new self($fullContent);
    }

    public function execute(): void
    {
        $response = $this->client->post((string) $this->endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'prompt' => $this->fullContent,
                'max_tokens' => 100,
            ],
        ]);

        $this->responseData = json_decode($response->getBody()->getContents(), true);
    }

    public function get(): Collection
    {
        return $this->execute();
    }
}