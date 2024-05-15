<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Entity;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class EntityFactory
{
    private ?int $name = null;

    public function __construct(
        private Collection $entities,
    ){}

    public static function new()
    {
        return new self(
            collect([self::build()])
        );
    }

    public function withLinked(int $name): self
    {
        $this->name = $name;

        return $this;
    }

    public static function build(?string $name = null): Entity
    {
        $faker = FakerFactory::create();

        return new Entity(
            $name ?? $faker->name(),
            $faker->word(),
            $faker->company(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times - 1; $i++) 
        {
            $this->entities->push($this->build($this->name));
        }

        return new self($this->entities);
        
    }

    public function create()
    {
        if($this->entities->count() === 1) 
        {
            return $this->entities->first();
        }

        return $this->entities;
    }
}