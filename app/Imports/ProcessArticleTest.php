<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\ProcessArticleDomain;
use App\Testing\TestCase;
use Database\OpenAi\DataFactory;
use Illuminate\Support\Facades\Bus;
use Mockery;
use App\Scraper\Article;

use PHPUnit\Framework\Attributes\Test;

class ProcessArticleTest extends TestCase
{
    #[Test]
    public function CanProcessArticleWithProcessedData(): void
    {
        #TODO: reanable bus fake
        // Bus::fake();

        $data = DataFactory::new()->create();
        $scraperArticle = new Article(
            $data->article()->title(),
            $data->article()->url(),
            $data->article()->organizationId(),
            $data->article()->fullContent(),
        );

        $processArticleMock = Mockery::mock(ProcessArticle::class, [$scraperArticle])->makePartial();
        $processArticleMock->shouldReceive('getData')->once()->andReturn($data);

        $processArticleMock->handle();

        #TODO: add more assertions
        // Bus::assertDispatched(ProcessArticleDomain::class);
    }
}