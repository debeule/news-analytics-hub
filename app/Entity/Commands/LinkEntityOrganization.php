<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\Entity\Entity;
use App\Entity\EntityHasOrganization;
use App\Entity\Organization;

use App\Entity\Queries\EntityByName;
use App\Entity\Queries\OrganizationByName;
use App\OpenAi\Entity as ExternalEntity;

class LinkEntityOrganization
{
    public function __construct(
        private ExternalEntity $externalEntity,
        private EntityByName $entityByName = new EntityByName,
        private OrganizationByName $organizationByName = new OrganizationByName,
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->externalEntity)->save();
    } 

    private function buildRecord(ExternalEntity $externalEntity): EntityHasOrganization
    {
        $entityHasOrganization = new EntityHasOrganization;

        $entityHasOrganization->author_id = $this->entityByName->hasName($externalEntity->name())->get()->id;
        $entityHasOrganization->organization_id = $this->organizationByName->hasName($externalEntity->organization())->get()->id;

        return $entityHasOrganization;
    }
}