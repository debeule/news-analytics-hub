<?php

declare(strict_types=1);

namespace Article\Commands;

use App\Article\Article;
use App\Article\Commands\SyncArticles;
use App\Article\Queries\ArticlesByOrganization;
use App\Article\Queries\ArticlesDiff;
use App\Imports\ProcessArticle;
use App\Imports\Queries\ExternalArticles;
use App\Testing\TestCase;
use Database\Factories\EntityFactory;

use Database\Factories\OrganizationFactory;
use Database\Scraper\ArticleFactory as ScraperArticleFactory;
use Illuminate\Bus\PendingBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Attributes\Test;

class SyncArticlesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itDispatchesBatchOfNewProcessArticleJobs(): void
    {
        Bus::fake();
        
        $organization = OrganizationFactory::new()->create();
        $entity = EntityFactory::new()->create();

        $externalArticles = ScraperArticleFactory::new()
            ->withOrganizationName($organization->name)
            ->withAuthorName($entity->name)
            ->count(2)
            ->create();
        
        $articlesByOrganizationMock = $this->createMock(ArticlesByOrganization::class);
        $articlesByOrganizationMock->method('get')->willReturn(Article::get());

        $externalArticlesMock = $this->createMock(ExternalArticles::class);
        $externalArticlesMock->method('get')->willReturn($externalArticles);

        $articlesDiff = new ArticlesDiff($articlesByOrganizationMock, $externalArticlesMock);
        $syncArticles = new SyncArticles();

        $syncArticles($articlesDiff);
        
        Bus::assertBatched(function (PendingBatch $batch) 
        {
            return $batch->jobs->every(function ($job) 
            {
                return $job instanceOf ProcessArticle;
            });
        });

        Bus::assertBatched(function (PendingBatch $batch) 
        {
            return $batch->jobs->count() === 2;
        });

        Bus::assertBatchCount(1);
    }
}