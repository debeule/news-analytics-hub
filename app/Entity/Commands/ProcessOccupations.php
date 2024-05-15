<?php

namespace App\Entity\Commands;

final class ProcessOccupations
{
    public function __construct(
        private collection $occupations,
    ) {}

    public function __invoke(): void
    {
        $filteredOccupations = $this->DispatchSync(new FilterAdditions(Occupation::get(), $this->occupation));
        
        foreach ($filteredOccupations as $occupation) 
        {
            $this->dispatchSync(new CreateOccupation($occupation));
        }
    }
}