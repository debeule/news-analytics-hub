<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Imports\Queries\ExternalArticles;
use App\Newspapers\NewspaperArticles;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ExternalArticles::class, NewspaperArticles::class);
    }
}
