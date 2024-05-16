<?php

declare(strict_types=1);


namespace App\Entity\Commands;

use App\Entity\Occupation as DbOccupation;
use App\Imports\Dtos\Occupation;

final class CreateOccupation
{
    public function __construct(
        public Occupation $occupation
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->occupation)->save();
    }   

    private function buildRecord(Occupation $occupation): DbOccupation
    {
        $newOccupation = new DbOccupation();
        
        $newOccupation->name = $occupation->name();
        $newOccupation->sector = $occupation->sector();

        return $newOccupation;
    }
}