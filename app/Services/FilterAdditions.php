<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class FilterAdditions
{
    public function __construct(
        private Collection $existingRecords,
        private Collection $externalRecords,
        private ?string $searchField = null,
    ){}

    public function handle(): Collection
    {
        if($this->searchField === 'title') return $this->filterByTitle();

        return $this->filterByName();
        
    }

    private function filterByName(): Collection
    {
        $newRecords = collect();
         
        foreach ($this->externalRecords as $externalRecord) 
        {
            if($this->existingRecords->where('name', $externalRecord->name())->isEmpty())
            {
                $newRecords->push($externalRecord);
            }
        }

        return $newRecords;
    }

    private function filterByTitle(): Collection
    {
        $newRecords = collect();

        foreach ($this->externalRecords as $externalRecord) 
        {
            if($this->existingRecords->where('title', $externalRecord->title())->isEmpty())
            {
                $newRecords->push($externalRecord);
            }
        }
        
        return $newRecords;
    }
}