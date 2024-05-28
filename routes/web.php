<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use Http\Endpoints\TestHandler;
use Http\Endpoints\ScrapeArticlesListHandler;

Route::get('/', function () {
    return redirect('/horizon');
});