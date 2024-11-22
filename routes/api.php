<?php
use App\Http\Controllers\ApiController\ApiController;
use App\Http\Controllers\Backend\PageDesignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetch-header-data', [ApiController::class, 'fetchHeaderData']); // Fetch all header data
Route::get('/', [ApiController::class, 'fetchHomeData']); // Fetch all header data
Route::get('about-us', [ApiController::class, 'fetchAboutData']); // Fetch all header data
Route::get('service', [ApiController::class, 'fetchServicesData']); // Fetch all header data
Route::get('useful-links', [ApiController::class, 'fetchUsefullLinlsData']); // Fetch all header data
Route::get('latest-news', [ApiController::class, 'fetchLatestNewsData']); // Fetch all header data
Route::get('website-style', [ApiController::class, 'fetchWebsiteStyle']); // Fetch all website-style data
Route::post('save-contact', [ApiController::class, 'saveContactData']); // Fetch all website-style data
