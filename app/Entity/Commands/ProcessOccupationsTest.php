<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\Kohera\Occupation as KoheraOccupation;
use App\Entity\Occupation;
use App\Testing\TestCase;
use Database\OpenAi\OccupationFactory as OpenAiOccupationFactory;
use PHPUnit\Framework\Attributes\Test;

final class ProcessOccupationsTest extends TestCase
{
    #[Test]
    public function itCreatesOccupationRecordsWhenNotExists(): void
    {
        $externalOccupations = OpenAiOccupationFactory::new()->count(2)->create();

        $this->dispatchSync(new ProcessOccupations($externalOccupations));

        $this->assertEquals(Occupation::count(), $externalOccupations->count());
    }

    #[Test]
    public function itDoesNotCreatesOccupationRecordsWhenExists(): void
    {
        $externalOccupations = OpenAiOccupationFactory::new()->count(2)->create();

        $this->dispatchSync(new CreateOccupation($externalOccupations->first()));

        $occupationCount = Occupation::count();

        $this->dispatchSync(new ProcessOccupations($externalOccupations));

        $this->assertEquals($occupationCount, 1);
        $this->assertEquals(Occupation::count(), 2);
    }
}