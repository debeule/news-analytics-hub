<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\ProcessArticleDomain;
use App\Entity\Commands\ProcessEntityDomain;
use App\Mention\Commands\ProcessMentionDomain;
use App\Testing\TestCase;
use Database\OpenAi\DataFactory;
use Illuminate\Support\Facades\Bus;
use Mockery;
use App\Scraper\Article;
use Illuminate\Support\Facades\Cache;

use PHPUnit\Framework\Attributes\Test;

class ScrapeArticleTest extends TestCase
{
    #[Test]
    public function CanProcessArticleWithProcessedData(): void
    {
        $data = DataFactory::new()->create();
        $scraperArticle = new Article(
            $data->article()->title(),
            $data->article()->url(),
            $data->article()->organizationId(),
            $data->article()->fullContent(),
        );

        $processArticleMock = Mockery::mock(ScrapeArticle::class, [$scraperArticle])->makePartial();
        $processArticleMock->shouldReceive('scrapeArticleContent')->once()->andReturn($data->article()->fullContent());

        $processArticleMock->handle();

        
        $this->assertEquals($scraperArticle->fullContent, $data->article()->fullContent());
        $this->assertNotNull($scraperArticle->fullContent, $data->article()->fullContent());

        $this->assertNotNull(Cache::get('article_full_content_' . $data->article()->organizationId() . '_' . $data->article()->title(), $data->article()->fullContent()));
    }
}