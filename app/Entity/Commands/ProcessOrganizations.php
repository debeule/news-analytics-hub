<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\Entity\Organization;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use App\Services\FilterAdditions;

final class ProcessOrganizations
{
    use DispatchesJobs;

    public function __construct(
        private collection $organizations,
    ) {}

    public function __invoke(): void
    {
        $filteredOrganizations = $this->DispatchSync(new FilterAdditions(Organization::get(), $this->organizations));
        
        foreach ($filteredOrganizations as $organization) 
        {
            $this->dispatchSync(new CreateOrganization($organization));
        }
    }
}