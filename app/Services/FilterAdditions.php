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
        if($this->searchField === 'url') return $this->filterByUrl();

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

    private function filterByUrl(): Collection
    {
        $newRecords = collect();

        foreach ($this->externalRecords as $externalRecord) 
        {
            if($this->existingRecords->where('url', $externalRecord->url())->isEmpty())
            {
                $newRecords->push($externalRecord);
            }
        }
        
        return $newRecords;
    }
}