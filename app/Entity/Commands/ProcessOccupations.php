<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\Entity\Occupation;
use App\Services\FilterAdditions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class ProcessOccupations
{
    use DispatchesJobs;

    public function __construct(
        private collection $occupations,
    ) {}

    public function __invoke(): void
    {
        $filteredOccupations = $this->DispatchSync(new FilterAdditions(Occupation::get(), $this->occupations));
        
        foreach ($filteredOccupations as $occupation) 
        {
            $this->dispatchSync(new CreateOccupation($occupation));
        }
    }
}