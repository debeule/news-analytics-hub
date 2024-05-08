<?php

namespace App\Newspaper\Commands;

final class ProcessOccupations
{
    public function __construct(
        private collection $occupations,
    ) {}

    public function setup(Collection $occupations)
    {
        return new self($this->occupations = $occupations);
    }

    public function execute(): void
    {
        $filteredCategories = $this->DispatchSync(new FilterAdditions(Occupation::get(), $this->occupation));
        
        foreach ($this->occupations as $occupation) 
        {
            $this->dispatchSync(new CreateCategory($occupation));
        }
    }
}