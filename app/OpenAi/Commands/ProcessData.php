<?php

namespace App\OpenAi\Commands;

use App\Newspaper\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

use App\Imports\Values\OpenAiEndpoint;
use App\Services\PostRequest;

class ProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $fullContent,
        private OpenAiEndpoint $endpoint = new OpenAiEndpoint(),
    ) {}

    public static function setup(string $fullContent): self
    {
        return new self($fullContent);
    }

    public function execute(): void
    {
        PostRequest::setup(
            (string) $this->endpoint,
            ['data' => $this->fullContent]
        )->execute();
    }

    public function get(): Collection
    {
        return $this->execute();
    }
}