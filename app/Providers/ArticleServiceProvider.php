<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Imports\Queries\ExternalArticles;
use App\Scraper\Queries\AllArticles;

class ArticleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ExternalArticles::class, AllArticles::class);
    }
}
