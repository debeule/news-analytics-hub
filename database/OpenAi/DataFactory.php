<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Data;
use Database\Scraper\ArticleFactory;
use Faker\Factory as FakerFactory;

use Illuminate\Support\Collection;

final class DataFactory
{
    public function __construct(
        private Collection $mentions,
    ){}

    public static function new()
    {
        return new self(
            collect([self::build()])
        );
    }

    public static function build(): Data
    {
        $faker = FakerFactory::create();

        $organizations = OrganizationFactory::new()->count(3)->create();
        $entities = EntityFactory::new()->count(3)->create();

        return new Data(
            ArticleFactory::new()->create(),
            OccupationFactory::new()->count(3)->create(),
            $organizations,
            $entities,
            MentionFactory::new()->withLinked($entities->first()->name, $organizations->first()->name)->count(3)->create(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times - 1; $i++) 
        {
            $this->mentions->push($this->build());
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

    public function createArray(): array
    {
        $outputArray = [];

        foreach ($this->mentions as $mention) 
        {
            array_push($outputArray, array_values((array) $mention));
        }

        return $outputArray;
    }
}