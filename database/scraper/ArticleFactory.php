<?php

namespace Database\Scraper\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Scraper\Article;

final class ArticleFactory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'url' => $this->faker->url(),
            'full_content' => $this->faker->randomHtml(),
        ];
    }
}