<?php
use App\Http\Controllers\ApiController\AboutController;
use App\Http\Controllers\ApiController\ApiController;
use App\Http\Controllers\ApiController\ContactController;
use App\Http\Controllers\ApiController\HeaderController; 
use App\Http\Controllers\ApiController\HomeController;
use App\Http\Controllers\ApiController\LatestNewsController;
use App\Http\Controllers\ApiController\ServicesController;
use App\Http\Controllers\ApiController\UsefullLinlsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/header', [HeaderController::class, 'addOrUpdateHeader']); // Add or Update header data
Route::delete('/header/{id}', [HeaderController::class, 'deleteHeader']); // Delete section header

Route::get('fetch-header-data', [ApiController::class, 'fetchHeaderData']); // Fetch all header data
Route::get('fetch-home-data', [ApiController::class, 'fetchHomeData']); // Fetch all header data
Route::get('fetch-about-data', [ApiController::class, 'fetchAboutData']); // Fetch all header data
Route::get('fetch-services-data', [ApiController::class, 'fetchServicesData']); // Fetch all header data
Route::get('fetch-usefull-linls-data', [ApiController::class, 'fetchUsefullLinlsData']); // Fetch all header data
Route::get('fetch-latest-news-data', [ApiController::class, 'fetchLatestNewsData']); // Fetch all header data

// Route::get('fetch-header-data', [HeaderController::class, 'fetchHeaderData']); // Fetch all header data
Route::post('/home', [HomeController::class, 'addOrUpdateHome']); // Add or Update home
Route::get('/home/{id?}', [HomeController::class, 'deleteHome']); // Delete section home
// Route::get('fetch-home-data',[HomeController::class,'fetchHomeData']); // Fetch all home data 

Route::post('/about', [AboutController::class, 'addOrUpdateAbout']); // Add or Update about
Route::get('/about/{id?}', [AboutController::class, 'deleteAbout']); // Delete section about
// Route::get('fetch-about-data',[AboutController::class,'fetchAboutData']); // Fetch all about data 

Route::post('/services',[ServicesController::class,'addOrUpdateServices']); // Add or Update services data
Route::get('/services/{id?}',[ServicesController::class,'deleteServices']); // Delete section services
// Route::get('fetch-services-data',[servicesController::class,'fetchServicesData']); // Fetch all services data 

Route::post('/usefull-linls', [UsefullLinlsController::class, 'addOrUpdateUsefullLinls']); // Add or Update usefull-linls
Route::get('/usefull-linls/{id?}', [UsefullLinlsController::class, 'deleteUsefullLinls']); // Delete section usefull-linls
// Route::get('fetch-usefull-linls-data',[UsefullLinlsController::class,'fetchUsefullLinlsData']); // Fetch all usefull-linls data 

Route::post('/latest-news', [LatestNewsController::class, 'addOrUpdateLatestNews']); // Add or Update latest-news
Route::get('/latest-news/{id?}', [LatestNewsController::class, 'deleteLatestNews']); // Delete section latest-news
// Route::get('fetch-latest-news-data',[LatestNewsController::class,'fetchLatestNewsData']); // Fetch all latest-news data 

Route::post('/contact', [ContactController::class, 'addOrUpdateContact']); // Add or Update Contact
Route::get('/contact/{id?}', [ContactController::class, 'deleteContact']); // Delete section contact
Route::get('fetch-contact-data',[ContactController::class,'fetchContactData']);
Route::post('/add-contact', [ContactController::class, 'addContact']); // Add or Update Contact
