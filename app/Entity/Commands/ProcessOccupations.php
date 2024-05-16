<?php

namespace App\Entity\Commands;

use Illuminate\Support\Collection;
use App\Entity\Occupation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\FilterAdditions;

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