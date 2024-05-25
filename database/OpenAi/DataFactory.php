<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\Imports\Collections\MentionCollection;
use App\OpenAi\Data;
use Faker\Factory as FakerFactory;

final class DataFactory
{
    public function __construct(
        private MentionCollection $mentions,
    ){}

    public static function new()
    {
        return new self(new MentionCollection);
    }

    public static function build(): Data
    {
        $faker = FakerFactory::create();

        $organizations = OrganizationFactory::new()->count(3)->create();
        $occupations = OccupationFactory::new()->count(3)->create();
        
        $entities = EntityFactory::new()
            ->withOrganizationName($organizations->first()->name())
            ->withOccupationName($occupations->first()->name())
            ->count(3)
            ->create();

        return new Data(
            ArticleFactory::new()->create(),
            $occupations,
            $organizations,
            $entities,
            MentionFactory::new()->withLinked($entities->first()->name, $organizations->first()->name)->count(3)->create(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->mentions->push($this->build());
        }

        return new self($this->mentions);
        
    }

    public function create()
    {
        if ($this->mentions->isEmpty()) 
        {
            $this->mentions->push($this->build());
        }

        if($this->mentions->count() === 1) 
        {
            return $this->mentions->first();
        }

        return $this->mentions;
    }
}