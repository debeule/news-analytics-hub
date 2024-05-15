<?php 

namespace App\OpenAi;

use App\Imports\Dtos\Occupation as OccupationInterface;

class Occupation implements OccupationInterface
{
    public function __construct(
        public string $name,
    ){}

    public function name(): string
    {
        return $this->name;
    }
}