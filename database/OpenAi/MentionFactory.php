<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Mention;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

use App\OpenAi\Entity;
use App\OpenAi\Organization;

final class MentionFactory
{
    private ?string $entityName = null;
    private ?string $organizationName = null;

    public function __construct(
        private Collection $mentions,
    ){}

    public static function new()
    {
        return new self(collect());
    }

    public function withLinked(string $entityName, string $organizationName): self
    {
        $this->entityName = $entityName;
        $this->organizationName = $organizationName;

        return $this;
    }

    public static function build(string $entityName = null, string $organizationName = null): Mention
    {
        $faker = FakerFactory::create();

        return new mention(
            $entityName ?? EntityFactory::new()->create()->name,
            $organizationName ?? OrganizationFactory::new()->create()->name,
            $faker->sentence(),
            $faker->numberBetween(1, 16),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->mentions->push($this->build($this->entityName, $this->organizationName));
        }

        return new self($this->mentions);
        
    }

    public function create()
    {
        if($this->mentions->count() === 1) 
        {
            return $this->mentions->first();
        }

        return $this->mentions;
    }
}