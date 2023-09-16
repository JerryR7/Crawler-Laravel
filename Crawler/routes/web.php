<?php

use App\Http\Controllers\CrawlerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('crawler', [CrawlerController::class, 'index'])->name("crawler");
Route::post('crawler', [CrawlerController::class, 'crawl'])->name("crawl");
Route::get('crawler/crawledRecords', [CrawlerController::class, 'crawledRecords'])->name("records");;
Route::post('crawler/crawledRecords', [CrawlerController::class, 'searchRecords'])->name("search");;
//Route::get('crawler/searchRecords', [CrawlerController::class, 'searchRecords'])->name("searchRecords");;
