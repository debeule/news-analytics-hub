<?php

namespace App\Imports;

use App\Imports\ProcessArticle;
use App\Article\Queries\ArticleByTitle;
use App\OpenAi\Commands\ProcessData;
use App\OpenAi\Commands\CreateDataObject;
use App\Imports\Dtos\Article as ExternalArticle;
use App\Article\Commands\ProcessArticleDomain;
use App\Article\Commands\ProcessEntityDomain;
use App\Article\Commands\ProcessMentionDomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Bus;
use Mockery\MockInterface;
use Mockery;

use Database\OpenAi\DataFactory;

class ProcessArticleTest extends TestCase
{
    #[Test]
    public function CanProcessArticleWithProcessedData()
    {
        Bus::fake();

        $data = DataFactory::new()->create();

        $processArticle = new ProcessArticle($data->article());

        $processArticleMock = Mockery::mock(ProcessArticle::class, [$data->article()])->makePartial();
        $processArticleMock->shouldReceive('getData')->once()->andReturn($data);

        $processArticleMock->handle();

        Bus::assertDispatchedSync(ProcessEntityDomain::class);
        Bus::assertDispatchedSync(ProcessArticleDomain::class);
        Bus::assertDispatchedSync(ProcessMentionDomain::class);
    }
}