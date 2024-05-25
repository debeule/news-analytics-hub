<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Article;
use Database\Factories\EntityFactory;
use Database\Factories\OrganizationFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class ArticleFactory
{
    private ?int $organizationId = null;
    private ?string $authorName = null;
    private ?string $exampleArticle = null;

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

    public function withAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public static function build(int $organizationId = null, string $authorName = null): Article
    {
        $faker = FakerFactory::create();

        return new Article(
            $faker->text(10),
            $faker->url(),
            $faker->text(2000, 4000) . 'author: ' . $faker->name(),
            $faker->word(),
            $organizationId ?? OrganizationFactory::new()->create()->id,
            $authorName ?? EntityFactory::new()->create()->name,
            $faker->dateTime()->format('Y-m-d H:i'),
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->articles->push($this->build($this->organizationId, $this->authorName));
        }

        return new self($this->articles);
        
    }

    public function create()
    {
        if ($this->articles->isEmpty()) 
        {
            $this->articles->push($this->build($this->organizationId, $this->authorName));
        }

        if($this->articles->count() === 1) 
        {
            return $this->articles->first();
        }

        return $this->articles;
    }
}