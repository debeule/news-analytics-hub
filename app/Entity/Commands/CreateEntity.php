<?php

declare(strict_types=1);


namespace App\Entity\Commands;

use App\Entity\Entity as DbEntity;
use App\Imports\Dtos\Entity;

final class CreateEntity
{
    public function __construct(
        public entity $entity
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->entity)->save();
    }   

    private function buildRecord(entity $entity): DbEntity
    {
        $newEntity = new DbEntity();
        
        $newEntity->name = $entity->name();

        return $newEntity;
    }
}