<?php

namespace App\Newspaper\Commands;

final class ProcessOrganizations
{
    public function __construct(
        private collection $organizations,
    ) {}

    public function setup(Collection $organizations)
    {
        return new self($this->organizations = $organizations);
    }

    public function execute(): void
    {
        $filteredCategories = $this->DispatchSync(new FilterAdditions(Organization::get(), $this->organization));
        
        foreach ($filteredCategories as $organization) 
        {
            $this->dispatchSync(new CreateCategory($organization));
        }
    }
}