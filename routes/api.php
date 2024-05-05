<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Http\Endpoints\SyncHandler;
use Http\Endpoints\TestHandler;

Route::prefix('v1')->group(function () 
{
    Route::get('/sync', SyncHandler::class);
    Route::get('/test', TestHandler::class);
});