<?php

declare(strict_types=1);

namespace Database\Scraper;

use App\Scraper\Article;
use Database\Factories\OrganizationFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class ArticleFactory
{
    private ?int $organizationId = null;

    public function __construct(
        private Collection $articles,
    ){}

    public static function new()
    {
        return new self(collect());
    }

    public function withOrganizationId(int $organizationId): self
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    public static function build(?int $organizationId): Article
    {
        $faker = FakerFactory::create();

        return new Article(
            $faker->text(10),
            $faker->url(),
            $organizationId ?? OrganizationFactory::new()->create()->id,
            $faker->text(2000, 4000) . ' author: ' . $faker->name(),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->articles->push($this->build($this->organizationId));
        }

        return new self($this->articles);
        
    }

    public function create()
    {
        if ($this->articles->isEmpty()) 
        {
            $this->articles->push($this->build($this->organizationId));
        }

        if($this->articles->count() === 1) 
        {
            return $this->articles->first();
        }

        return $this->articles;
    }
}