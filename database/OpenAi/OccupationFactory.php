<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\Imports\Collections\OccupationCollection;
use App\OpenAi\Occupation;
use Faker\Factory as FakerFactory;

final class OccupationFactory
{
    private ?string $name = null;

    public function __construct(
        private OccupationCollection $occupations,
    ){}

    public static function new()
    {
        return new self(new OccupationCollection);
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public static function build(string $name = null): Occupation
    {
        $faker = FakerFactory::create();

        return new Occupation(
            $name ?? $faker->name(),
            $faker->name(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->occupations->push($this->build($this->name));
        }

        return new self($this->occupations);
        
    }

    public function create()
    {
        if ($this->occupations->isEmpty()) 
        {
            $this->occupations->push($this->build());
        }
        
        if($this->occupations->count() === 1) 
        {
            return $this->occupations->first();
        }

        return $this->occupations;
    }
}