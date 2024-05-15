<?php

namespace App\Entity\Commands;

final class ProcessEntities
{
    public function __construct(
        private collection $entities,
    ) {}

    public function __invoke(): void
    {
        $filteredEntities = $this->DispatchSync(new FilterAdditions(Entity::get(), $this->entity));
        
        foreach ($filteredEntities as $entity) 
        {
            $this->dispatchSync(new CreateEntity($entity));
            $this->dispatchSync(new LinkEntityOccupation($entity));
            $this->dispatchSync(new LinkEntityOrganization($entity));
        }
    }
}