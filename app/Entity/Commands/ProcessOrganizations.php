<?php

declare(strict_types=1);

namespace App\Entity\Commands;

final class ProcessOrganizations
{
    public function __construct(
        private collection $organizations,
    ) {}

    public function __invoke(): void
    {
        $filteredOrganizations = $this->DispatchSync(new FilterAdditions(Organization::get(), $this->organization));
        
        foreach ($filteredOrganizations as $organization) 
        {
            $this->dispatchSync(new CreateOrganization($organization));
        }
    }
}