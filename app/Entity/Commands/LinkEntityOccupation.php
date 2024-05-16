<?php

namespace App\Entity\Commands;

use App\openAi\Entity as ExternalEntity;
use App\Entity\Entity;
use App\Entity\Occupation;

class LinkEntityOccupation
{
    private Entity $entity;
    private Occupation $occupation;

    public function __construct(
        private ExternalEntity $externalEntity,
    ) {
        dd(Occupation::get(), $this->externalEntity->occupatPion());
        #TODO: put finding of record in interface / implementationif interface
        $this->entity = Entity::where('name', $this->externalEntity->name())->firstOrFail();
        $this->occupation = Occupation::where('name', $this->externalEntity->occupation())->firstOrFail();
    }

    public function __invoke(): void
    {
        dd($this->entity, $this->occupation);
    }
}