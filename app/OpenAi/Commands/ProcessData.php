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
use App\Imports\Values\GuzzleResponse;

class ProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private array $headers;

    public function __construct(
        private string $fullContent,
        private OpenAiEndpoint $endpoint = new OpenAiEndpoint(),
        private Client $client = new Client(),
    ) {
        $this->data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user', 
                    'content' => config('scraping.processing.prompt') . '\n' . $this->fullContent
                ],
            ],
            'max_tokens' => 4096,
        ];

        $this->headers = [
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ];
    }

    public static function setup(string $fullContent): self
    {
        return new self($fullContent);
    }

    public function execute(): Array
    {
        $response = PostRequest::setup(
            (string) $this->endpoint,
            $this->headers,
            $this->data,
        )->execute();

        return GuzzleResponse::fromResponse($response)->extractOpenAiResponse();
    }

    public function get(): Array
    {
        return $this->execute();
    }
}