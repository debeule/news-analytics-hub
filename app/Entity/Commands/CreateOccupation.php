<?php 

namespace App\Entity\Commands;

use App\Imports\Dtos\Occupation;
use App\Entity\Occupation as DbOccupation;

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