<?php

namespace App\Newspaper\Commands;

final class ProcessEntities
{
    public function __construct(
        private collection $entities,
    ) {}

    public function setup(Collection $entities)
    {
        return new self($this->entities = $entities);
    }

    public function execute(): void
    {
        $filteredEntities = $this->DispatchSync(new FilterAdditions(Entity::get(), $this->entities));
        
        foreach ($filteredEntities as $entity) 
        {
            $this->dispatchSync(new CreateEntity($entity));
        }
    }
}