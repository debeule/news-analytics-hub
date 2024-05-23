<?php

declare(strict_types=1);

namespace App\OpenAi\Commands;

use App\Imports\Values\GuzzleResponse;
use App\Imports\Values\OpenAiEndpoint;
use App\Services\PostRequest;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
                    'content' => config('Processing.prompt') . '\n' . $this->fullContent,
                ],
            ],
            'max_tokens' => 4096,
        ];

        $this->headers = [
            'Authorization' => 'Bearer ' . config('Processing.openai_api_key'),
            'Content-Type' => 'application/json',
        ];
    }

    public function execute(): Array
    {
        $response = PostRequest::setup(
            (string) $this->endpoint,
            $this->data,
            $this->headers,
        )->execute();

        return GuzzleResponse::fromResponse($response)->extractOpenAiResponse();
    }

    public function get(): Array
    {
        return $this->execute();
    }
}