<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use Http\Endpoints\TestHandler;
use Http\Endpoints\ScrapeArticlesListHandler;

Route::get('/test', TestHandler::class)->name('test');

Route::get('/', function () 
{
    return view('dashboard');
});

Route::get('/dispatch', ScrapeArticlesListHandler::class)->name('dispatch');