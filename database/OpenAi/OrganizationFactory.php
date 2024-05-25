<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\Imports\Collections\OrganizationCollection;
use App\OpenAi\Organization;
use Faker\Factory as FakerFactory;

final class OrganizationFactory
{
    public function __construct(
        private OrganizationCollection $organizations,
    ){}

    public static function new()
    {
        return new self(new OrganizationCollection);
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
        for ($i = 0; $i < $times; $i++) 
        {
            $this->organizations->push($this->build());
        }

        return new self($this->organizations);
        
    }

    public function create()
    {
        if ($this->organizations->isEmpty()) 
        {
            $this->organizations->push($this->build());
        }

        if($this->organizations->count() === 1) 
        {
            return $this->organizations->first();
        }

        return $this->organizations;
    }
}