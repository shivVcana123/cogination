<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LatestNewsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UsefullLinlsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/header',[HeaderController::class,'addOrUpdateHeader']); // Add or Update header data
Route::get('/header/{id?}',[HeaderController::class,'deleteHeader']); // Delete section header
Route::get('fetch-header-data',[HeaderController::class,'fetchHeaderData']); // Fetch all header data 

Route::post('/home', [HomeController::class, 'addOrUpdateHome']); // Add or Update home
Route::get('/home/{id?}', [HomeController::class, 'deleteHome']); // Delete section home
Route::get('fetch-home-data',[HomeController::class,'fetchHomeData']); // Fetch all home data 

Route::post('/about', [AboutController::class, 'addOrUpdateAbout']); // Add or Update about
Route::get('/about/{id?}', [AboutController::class, 'deleteAbout']); // Delete section about
Route::get('fetch-about-data',[AboutController::class,'fetchAboutData']); // Fetch all about data 

Route::post('/services',[ServicesController::class,'addOrUpdateServices']); // Add or Update services data
Route::get('/services/{id?}',[ServicesController::class,'deleteServices']); // Delete section services
Route::get('fetch-services-data',[servicesController::class,'fetchServicesData']); // Fetch all services data 

Route::post('/usefull-linls', [UsefullLinlsController::class, 'addOrUpdateUsefullLinls']); // Add or Update usefull-linls
Route::get('/usefull-linls/{id?}', [UsefullLinlsController::class, 'deleteUsefullLinls']); // Delete section usefull-linls
Route::get('fetch-usefull-linls-data',[UsefullLinlsController::class,'fetchUsefullLinlsData']); // Fetch all usefull-linls data 

Route::post('/latest-news', [LatestNewsController::class, 'addOrUpdateLatestNews']); // Add or Update latest-news
Route::get('/latest-news/{id?}', [LatestNewsController::class, 'deleteLatestNews']); // Delete section latest-news
Route::get('fetch-latest-news-data',[LatestNewsController::class,'fetchLatestNewsData']); // Fetch all latest-news data 

Route::post('/contact', [ContactController::class, 'addOrUpdateContact']); // Add or Update Contact
