<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Imports\SyncAllSources;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncHandler
{
    use DispatchesJobs;

    public function __invoke(): JsonResponse
    {
        try 
        {
            $this->dispatch(new SyncAllSources);
        } 
        catch (\Throwable $th) 
        {
            return response()->json($th, 500);
        }

        return Response()->json('Syncing', 200);
    }
}