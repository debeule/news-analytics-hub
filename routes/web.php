<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Test2Controller;
use App\Http\Controllers\GetDashboardController;
use App\Http\Controllers\ScrapeArticlesListController;


Route::get('/test', TestController::class)->name('test');
Route::get('/test2', Test2Controller::class)->name('test2');

Route::get('/', GetDashboardController::class)->name('dashboard');
Route::get('/dispatch', ScrapeArticlesListController::class)->name('dispatch');
