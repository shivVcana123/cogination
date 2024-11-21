<?php
use App\Http\Controllers\ApiController\ApiController;
use App\Http\Controllers\Backend\PageDesignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('header', [ApiController::class, 'fetchHeaderData']); // Fetch all header data
Route::get('home', [ApiController::class, 'fetchHomeData']); // Fetch all header data
Route::get('about', [ApiController::class, 'fetchAboutData']); // Fetch all header data
Route::get('service', [ApiController::class, 'fetchServicesData']); // Fetch all header data
Route::get('link', [ApiController::class, 'fetchUsefullLinlsData']); // Fetch all header data
Route::get('news', [ApiController::class, 'fetchLatestNewsData']); // Fetch all header data
Route::get('website-style', [ApiController::class, 'fetchWebsiteStyle']); // Fetch all website-style data