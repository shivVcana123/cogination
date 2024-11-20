<?php
use App\Http\Controllers\ApiController\ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetch-header-data', [ApiController::class, 'fetchHeaderData']); // Fetch all header data
Route::get('fetch-home-data', [ApiController::class, 'fetchHomeData']); // Fetch all header data
Route::get('fetch-about-data', [ApiController::class, 'fetchAboutData']); // Fetch all header data
Route::get('fetch-services-data', [ApiController::class, 'fetchServicesData']); // Fetch all header data
Route::get('fetch-usefull-links-data', [ApiController::class, 'fetchUsefullLinlsData']); // Fetch all header data
Route::get('fetch-latest-news-data', [ApiController::class, 'fetchLatestNewsData']); // Fetch all header data
