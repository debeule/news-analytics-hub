<?php

declare(strict_types=1);

namespace App\Services;

use App\Article\Article;
use App\Article\Commands\CreateArticle;
use App\Scraper\Article as ScraperArticle;
use App\Testing\TestCase;
use Database\Factories\OrganizationFactory;
use Database\Scraper\ArticleFactory as ScraperArticleFactory;
use Database\OpenAi\ArticleFactory as ExternalArticleFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class FilterAdditionsTest extends TestCase
{
    #[Test]
    public function createContainsNewRecords(): void
    {
        $result = $this->DispatchSync(new FilterAdditions(
            collect(),
            ScraperArticleFactory::new()->count(3)->create(),
            'title'
        ));
            
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(ScraperArticle::class, $result->first());
        $this->assertEquals(3, $result->count());
    }

    #[Test]
    public function createDoesNotContainExistingRecords(): void
    {
        $organization = Organizationfactory::new()->create();
        $externalArticles = ExternalArticleFactory::new()->withOrganizationId($organization->id)->count(3)->create();


        $this->DispatchSync(new CreateArticle($externalArticles->first()));

        $result = $this->DispatchSync(new FilterAdditions(
            Article::get(),
            $externalArticles,
            'title'
        ));
        
        $this->assertEquals(2, $result->count());
    }
}