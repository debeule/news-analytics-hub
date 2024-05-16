<?php

declare(strict_types=1);


namespace App\OpenAi;

use App\Entity\Entity;
use App\Entity\Organization;
use App\Imports\Dtos\Mention as MentionInterface;

class Mention implements MentionInterface
{
    public function __construct(
        public string $context,
        public int $sentiment,
        public string $entityName,
        public string $organizationName,
    ){}

    public function context(): string
    {
        return $this->context;
    }

    public function sentiment(): int
    {
        return $this->sentiment;
    }

    public function entity(): Entity
    {
        return Entity::where('name', $this->entityName)->first();
    }

    public function organization(): Organization
    {
        return Organization::where('name', $this->organizationName)->first();
    }
}