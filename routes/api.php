<?php

use App\Http\Controllers\HeaderController;
use App\Http\Controllers\HomeController;
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

Route::post('/header',[HeaderController::class,'addOrUpdateHeader']);
Route::get('/header/{id?}',[HeaderController::class,'deleteHeader']);
Route::get('fetch-header-data',[HeaderController::class,'fetchHeaderData']);

Route::post('/home', [HomeController::class, 'addOrUpdateHome']); // Add or Update home
Route::delete('/home/{id?}', [HomeController::class, 'deleteHome']); // Delete home
Route::get('fetch-home-data',[HomeController::class,'fetchHomeData']);

