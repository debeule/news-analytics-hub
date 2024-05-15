<?php

namespace Article\Commands;

use App\Article\Article;
use App\Article\Commands\SyncArticles;
use App\Entity\Organization;
use App\Article\Queries\ArticlesDiff;
use Illuminate\Bus\Batch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Bus\PendingBatch;

use Database\Scraper\ArticleFactory as ScraperArticleFactory;
use Database\Factories\OrganizationFactory;
use App\Article\Commands\ProcessArticle;
use App\Imports\Queries\ExternalArticles;
use App\Article\Queries\ArticlesByOrganization;

class SyncArticlesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itDispatchesBatchOfNewProcessArticleJobs()
    {
        $organization = OrganizationFactory::new()->create();
        $externalArticles = ScraperArticleFactory::new()->withOrganizationId($organization->id)->count(2)->create();
        
        $articlesByOrganizationMock = $this->createMock(ArticlesByOrganization::class);
        $articlesByOrganizationMock->method('get')->willReturn(Article::get());

        $externalArticlesMock = $this->createMock(ExternalArticles::class);
        $externalArticlesMock->method('get')->willReturn($externalArticles);

        $articlesDiff = new ArticlesDiff($articlesByOrganizationMock, $externalArticlesMock);

        Bus::fake();

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