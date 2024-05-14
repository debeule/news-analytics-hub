<?php

namespace App\Entity\Commands;

use App\Entity\Entity;

final class ProcessEntityDomain
{
    public function __construct(
        private Collection $data,
        private int $articleId,
    ){}

    public function __invoke(): void
    {
        $this->dispatchSync(new ProcessOccupations($this->data->occupations));
        $this->dispatchSync(new ProcessOrganizations($this->data->organizations));
        $this->dispatchSync(new ProcessEntities($this->data->entities));
    }
}