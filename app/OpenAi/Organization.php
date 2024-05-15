<?php 

namespace App\OpenAi;

use App\Imports\Dtos\Organization as OrganizationInterface;

class Organization implements OrganizationInterface
{
    public function __construct(
        public string $name,
        public string $sector,
    ){}

    public function name(): string
    {
        return $this->name;
    }

    public function sector(): string
    {
        return $this->sector;
    }
}