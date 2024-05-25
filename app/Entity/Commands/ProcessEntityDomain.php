<?php

declare(strict_types=1);

namespace App\Entity\Commands;

use App\OpenAi\Data;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class ProcessEntityDomain
{
    use DispatchesJobs;

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