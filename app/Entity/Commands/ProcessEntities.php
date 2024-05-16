<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\Entity\Entity;
use App\Services\FilterAdditions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class ProcessEntities
{
    use DispatchesJobs;

    public function __construct(
        private collection $entities,
    ) {}

    public function __invoke(): void
    {
        $filteredEntities = $this->DispatchSync(new FilterAdditions(Entity::get(), $this->entities));
        
        foreach ($filteredEntities as $entity) 
        {
            $this->dispatchSync(new CreateEntity($entity));

            $this->dispatchSync(new LinkEntityOccupation($entity));
            $this->dispatchSync(new LinkEntityOrganization($entity));
        }
    }
}