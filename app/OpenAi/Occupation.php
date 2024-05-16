<?php

declare(strict_types=1);


namespace App\OpenAi;

use App\Imports\Dtos\Occupation as OccupationInterface;

class Occupation implements OccupationInterface
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