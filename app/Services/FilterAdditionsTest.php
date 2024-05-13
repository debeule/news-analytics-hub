<?php

declare(strict_types=1);

namespace App\Services;

use App\Newspaper\Article;
use App\Scraper\Article as ScraperArticle;
use App\Newspaper\Commands\CreateArticle;
use App\Testing\TestCase;
use Database\Scraper\ArticleFactory as ScraperArticleFactory;
use Database\Main\Factories\AddressFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use App\Services\FilterAdditions;
use Database\Factories\OrganizationFactory;

final class FilterAdditionsTest extends TestCase
{
    #[Test]
    public function createContainsNewRecords(): void
    {
        $result = $this->DispatchSync(new FilterAdditions(
            collect(),
            ScraperArticleFactory::new()->count(3)->create()
        ));
            
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(ScraperArticle::class, $result->first());
        $this->assertEquals(3, $result->count());
    }

    #[Test]
    public function createDoesNotContainExistingRecords(): void
    {
        $organization = Organizationfactory::new()->create();
        $externalArticles = ScraperArticleFactory::new()->withOrganizationId($organization->id)->count(3)->create();


        $this->DispatchSync(new CreateArticle($externalArticles->first()));

        $result = $this->DispatchSync(new FilterAdditions(
            Article::get(),
            $externalArticles
        ));
        
        $this->assertEquals(2, $result->count());
    }
}