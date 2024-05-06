<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class FilterAdditions
{
    public function __construct(
        private Collection $existingRecords,
        private Collection $externalRecords,
    ){}

    public function handle(): Collection
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