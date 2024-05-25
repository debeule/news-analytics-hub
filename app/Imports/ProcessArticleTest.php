<?php

declare(strict_types=1);

namespace App\Imports;

use App\Article\Article as DbArticle;
use App\Entity\Entity;
use App\Mention\Mention;
use App\Scraper\Article;
use App\Testing\TestCase;
use Database\OpenAi\DataFactory;
use Mockery;

use PHPUnit\Framework\Attributes\Test;

class ProcessArticleTest extends TestCase
{
    #[Test]
    public function CanProcessArticleWithProcessedData(): void
    {
        $data = DataFactory::new()->create();
        $scraperArticle = new Article(
            $data->article()->title(),
            $data->article()->url(),
            $data->article()->organizationId(),
        );

        $processArticleMock = Mockery::mock(ProcessArticle::class, [$scraperArticle])->makePartial();
        $processArticleMock->shouldReceive('getData')->once()->andReturn($data);

        $startingEntityCount = Entity::count();
        $startingMentionCount = Mention::count();

        $processArticleMock->handle();

        $article = DbArticle::where('title', $data->article()->title())->first();
        $entityCount = Entity::count();
        $mentionCount = Mention::count();

        $this->assertNotNull($article);
        $this->assertEquals($entityCount - $startingEntityCount, 3);
        $this->assertEquals($mentionCount - $startingMentionCount, 3);

    }
}