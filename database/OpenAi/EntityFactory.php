<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Entity;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class EntityFactory
{
    private ?string $name = null;
    private ?string $organizationName = null;
    private ?string $occupationName = null;

    public function __construct(
        private Collection $entities,
    ){}

    public static function new()
    {
        return new self(collect());
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withoccupationName(string $occupationName): self
    {
        $this->occupationName = $occupationName;

        return $this;
    }

    public function withOrganizationName(string $organizationName): self
    {
        $this->organizationName = $organizationName;

        return $this;
    }

    public static function build(?string $name = null, ?string $occupationName = null, ?string $organizationName = null): Entity
    {
        $faker = FakerFactory::create();

        return new Entity(
            $name ?? $faker->name(),
            $occupationName ?? $faker->word(),
            $organizationName ?? $faker->company(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->entities->push($this->build($this->name, $this->occupationName, $this->organizationName));
        }

        return new self($this->entities);
        
    }

    public function create()
    {
        if ($this->entities->isEmpty()) 
        {
            $this->entities->push($this->build($name = null, $organizationName = null, $occupationName = null));
        }

        if($this->entities->count() === 1) 
        {
            return $this->entities->first();
        }

        return $this->entities;
    }
}