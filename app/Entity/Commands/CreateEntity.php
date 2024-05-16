<?php 

namespace App\Entity\Commands;

use App\Imports\Dtos\entity;
use App\Entity\entity as DbEntity;

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
        $newEntity->sector = $entity->sector();

        return $newEntity;
    }
}