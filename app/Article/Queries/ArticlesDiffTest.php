<?php

declare(strict_types=1);

namespace App\Article\Queries;

use App\Article\Article as DbArticle;
use App\Imports\Queries\ExternalArticles;
use App\Scraper\Article;
use App\Testing\TestCase;
use Carbon\CarbonImmutable;
use Database\Factories\EntityFactory;
use Database\Factories\OrganizationFactory;
use Database\Scraper\ArticleFactory as ScraperArticleFactory;
use PHPUnit\Framework\Attributes\Test;

final class ArticlesDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectAdditions2(): void
    {
        $entity = EntityFactory::new()->create();
        $organization = OrganizationFactory::new()->create();

        $externalArticles = ScraperArticleFactory::new()
            ->withOrganizationId($organization->id)
            ->count(3)
            ->create();

        DbArticle::create([
            'title' => $externalArticles->first()->title,
             'word_count' => '100',
            'full_content' => 'abc',
            'url' => $externalArticles->first()->url,
            'article_created_at' => CarbonImmutable::now(),
            'category' => 'business',
            'author_id' => $entity->id,
            'organization_id' => $organization->id,
        ]);
        
        $externalArticlesMock = $this->createMock(ExternalArticles::class);
        $externalArticlesMock->method('get')->willReturn($externalArticles);

        $articlesDiff = new ArticlesDiff($externalArticlesMock);

        $result = $articlesDiff($organization->id)->additions();

        $this->assertInstanceOf(Article::class, $result->first());
        $this->assertEquals(2, $result->count());
    }
}