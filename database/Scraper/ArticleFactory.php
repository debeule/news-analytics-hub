<?php

declare(strict_types=1);

namespace Database\Scraper;

use App\Scraper\Article;
use Database\Factories\EntityFactory;
use Database\Factories\OrganizationFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class ArticleFactory
{
    private ?string $organizationName = null;
    private ?string $authorName = null;
    private ?string $exampleArticle = null;

    public function __construct(
        private Collection $articles,
    ){}

    public static function new()
    {
        return new self(collect());
    }

    public function withOrganizationName(string $organizationName): self
    {
        $this->organizationName = $organizationName;

        return $this;
    }

    public function withAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public static function build(string $organizationName = null, string $authorName = null): Article
    {
        $faker = FakerFactory::create();

        return new Article(
            $faker->text(10),
            $faker->url(),
            $organizationName ?? OrganizationFactory::new()->create()->name,
            EntityFactory::new()->create()->name,
            $exampleArticle ?? $faker->text(2000, 4000),
            $faker->word(),
            $faker->dateTime()->format('Y-m-d H:i'),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->articles->push($this->build($this->organizationName, $this->authorName));
        }

        return new self($this->articles);
        
    }

    public function create()
    {
        if ($this->articles->isEmpty()) 
        {
            $this->articles->push($this->build($this->organizationName, $this->authorName));
        }

        if($this->articles->count() === 1) 
        {
            return $this->articles->first();
        }

        return $this->articles;
    }
}