<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Commands\ProcessArticleDomain;
use App\Article\Commands\ProcessEntityDomain;
use App\Article\Commands\ProcessMentionDomain;
use App\Testing\TestCase;
use Database\OpenAi\DataFactory;
use Illuminate\Support\Facades\Bus;
use Mockery;

use PHPUnit\Framework\Attributes\Test;

class ProcessArticleTest extends TestCase
{
    #[Test]
    public function CanProcessArticleWithProcessedData(): void
    {
        #TODO: reanable bus fake
        // Bus::fake();

        $data = DataFactory::new()->create();

        dd($data);
        $processArticle = new ProcessArticle($data->article());

        $processArticleMock = Mockery::mock(ProcessArticle::class, [$data->article()])->makePartial();
        $processArticleMock->shouldReceive('getData')->once()->andReturn($data);

        $processArticleMock->handle();

        #TODO: add more assertions
        // Bus::assertDispatched(ProcessArticleDomain::class);
    }
}