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
use Database\Factories\ArticleFactory;
use Database\Scraper\ArticleFactory as ScraperArticleFactory;
use Illuminate\Bus\PendingBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Collection;

class SyncArticlesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itDispatchesBatchOfNewProcessArticleJobs(): void
    {
        Bus::fake();
        
        $organization = OrganizationFactory::new()->withSector('source_newspaper')->create();
        $entity = EntityFactory::new()->create();
        ArticleFactory::new()->withOrganizationId($organization->id)->create();

        $scraperArticles = ScraperArticleFactory::new()->count(2)->create();

        $externalArticlesMock = $this->createMock(ExternalArticles::class);
        $externalArticlesMock->method('get')->willReturn($scraperArticles);

        $articlesDiff = new ArticlesDiff($externalArticlesMock);
        
        $syncArticles = new SyncArticles($organization);

        $syncArticles($articlesDiff($organization->id));
        
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