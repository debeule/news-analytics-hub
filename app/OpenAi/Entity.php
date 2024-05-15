<?php 

namespace App\OpenAi;

use App\Imports\Dtos\Entity as EntityInterface;

class Entity implements EntityInterface
{
    public function __construct(
        public string $name,
        public string $occupation,
        public string $organization,
    ){}

    public function name(): string
    {
        return $this->name;
    }

    public function occupation(): string
    {
        return $this->occupation;
    }

    public function organization(): string
    {
        return $this->organization;
    }
}