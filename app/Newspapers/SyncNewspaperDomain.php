<?php

declare(strict_types=1);

namespace App\Raw;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRawDomain
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $this->DispatchSync(new SyncRaw);
        $this->DispatchSync(new SyncProcessed);
        //retrieve raw

        //insert raw

        //process start

        //ori
        foreach (Organization::get() as $organization) 
        {
            $this->DispatchSync(new SyncOrganization($organization));
        }
        $this->DispatchSync(new SyncSports);
    }
}
