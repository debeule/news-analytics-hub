<?php

declare(strict_types=1);


namespace App\Entity\Commands;

use App\Entity\Organization as DbOrganization;
use App\Imports\Dtos\Organization;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateOrganization
{
    use DispatchesJobs;

    public function __construct(
        public Organization $organization
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->organization)->save();
    }   

    private function buildRecord(Organization $organization): DbOrganization
    {
        $newOrganization = new DbOrganization();
        
        $newOrganization->name = $organization->name();
        $newOrganization->sector = $organization->sector();

        return $newOrganization;
    }
}