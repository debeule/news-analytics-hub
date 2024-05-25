<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Article\Article;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'word_count' => $this->faker->numberBetween(100, 1000),
            'full_content' => $this->faker->text(),
            'url' => $this->faker->url(),
            'article_created_at' => CarbonImmutable::now(),
            'category' => $this->faker->randomElement(['source_newspaper']),
            'author_id' => EntityFactory::new()->create()->id,
            'organization_id' => OrganizationFactory::new()->create()->id,
        ];
    }

    public function withOrganizationId(int $organizationId): self
    {
        return $this->state(['organization_id' => $organizationId]);
    }

    public function withAuthorId(int $authorId): self
    {
        return $this->state(['author_id' => $authorId]);
    }
}