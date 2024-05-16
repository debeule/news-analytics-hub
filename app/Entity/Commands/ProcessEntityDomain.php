<?php

namespace App\Entity\Commands;

use App\Entity\Entity;
use App\OpenAI\Data;

final class ProcessEntityDomain
{
    public function __construct(
        private Data $data,
    ){}

    public function __invoke(): void
    {
        $this->dispatchSync(new ProcessOccupations($this->data->occupations));
        $this->dispatchSync(new ProcessOrganizations($this->data->organizations));
        $this->dispatchSync(new ProcessEntities($this->data->entities));
    }
}