<?php

declare(strict_types=1);


namespace App\OpenAi;

use App\Imports\Dtos\Mention as MentionInterface;

class Mention implements MentionInterface
{
    public function __construct(
        public string $entity,
        public string $organization,
        public string $context,
        public int $sentiment,
    ){}

    public function entity(): string
    {
        return $this->entity;
    }

    public function organization(): string
    {
        return $this->organization;
    }

    public function context(): string
    {
        return $this->context;
    }

    public function sentiment(): int
    {
        return $this->sentiment;
    }
}