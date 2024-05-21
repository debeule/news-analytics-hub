<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Imports\SyncAllSources;
use App\Testing\TestCase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;

final class SyncHandlerTest extends TestCase
{
    #[Test]
    public function itDispatchesSyncAllSources(): void
    {
        Queue::fake();

        $syncHandler = new SyncHandler;
        $syncHandler();

        Queue::assertPushed(SyncAllSources::class);
    }

}