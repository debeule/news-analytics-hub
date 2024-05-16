<?php

declare(strict_types=1);

namespace Database\OpenAi;

use App\OpenAi\Mention;
use Database\Factories\ArticleFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;


final class MentionFactory
{
    private ?string $entityName = null;
    private ?string $organizationName = null;
    private ?int $articleId = null;

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

    public function withArticleId(int $articleId): self
    {
        $this->articleId = $articleId;

        return $this;
    }

    public static function build(string $entityName = null, string $organizationName = null, int $articleId = null): Mention
    {
        $faker = FakerFactory::create();

        return new mention(
            $faker->sentence(),
            $faker->numberBetween(1, 16),
            $entityName ?? EntityFactory::new()->create()->name,
            $organizationName ?? OrganizationFactory::new()->create()->name,
            $articleId ?? ArticleFactory::new()->create()->id,
        );
    }

    public function count(int $times): self
    {
        for ($i = 0; $i < $times; $i++) 
        {
            $this->mentions->push($this->build($this->entityName, $this->organizationName, $this->articleId));
        }

        return new self($this->mentions);
        
    }

    public function create()
    {
        if ($this->mentions->isEmpty()) 
        {
            $this->mentions->push($this->build($this->entityName, $this->organizationName, $this->articleId));
        }

        if($this->mentions->count() === 1) 
        {
            return $this->mentions->first();
        }

        return $this->mentions;
    }
}