<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Organization;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;


final class OrganizationFactory
{
    public function __construct(
        private Collection $occupations,
    ){}

    public static function new()
    {
        return new self(
            collect([self::build()])
        );
    }

    public static function build(): Organization
    {
        $faker = FakerFactory::create();

        return new Organization(
            $faker->name(),
            $faker->name(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times - 1; $i++) 
        {
            $this->occupations->push($this->build());
        }

        return new self($this->occupations);
        
    }

    public function create()
    {
        if($this->occupations->count() === 1) 
        {
            return $this->occupations->first();
        }

        return $this->occupations;
    }
}