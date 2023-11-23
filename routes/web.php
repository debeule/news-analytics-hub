<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GetDashboardController;
use App\Http\Controllers\ScrapeArticlesListController;

Route::get('/', GetDashboardController::class)->name('dashboard');
Route::get('/test', TestController::class)->name('test');
Route::get('/dispatch', ScrapeArticlesListController::class)->name('dispatch');

Route::get('/test-redis', function () {
    Redis::set('test-key', 'Hello, Redis!');
    return Redis::get('test-key');
});