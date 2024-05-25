<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\Entity\EntityHasOccupation;

use App\Entity\Queries\EntityByName;
use App\Entity\Queries\OccupationByName;
use App\OpenAi\Entity as ExternalEntity;

class LinkEntityOccupation
{
    public function __construct(
        private ExternalEntity $externalEntity,
        private EntityByName $entityByName = new EntityByName,
        private OccupationByName $occupationByName = new OccupationByName,
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->externalEntity)->save();
    } 

    private function buildRecord(ExternalEntity $externalEntity): EntityHasOccupation
    {
        $entityHasOccupation = new EntityHasOccupation;

        $entityHasOccupation->entity_id = $this->entityByName->hasName($externalEntity->name())->get()->id;
        $entityHasOccupation->occupation_id = $this->occupationByName->hasName($externalEntity->occupation())->get()->id;

        return $entityHasOccupation;
    }
}