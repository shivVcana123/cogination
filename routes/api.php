<?php

use App\Http\Controllers\HeaderController;
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

Route::post('add-or-update-category',[HeaderController::class,'addOrUpdateCategory']);
Route::get('category-delete/{id?}',[HeaderController::class,'categoryDelete']);


Route::post('add-or-update-sub-category',[HeaderController::class,'addOrUpdateSubCategory']);
Route::get('sub-category-delete/{id?}',[HeaderController::class,'subCategoryDelete']);

Route::get('fetch-category-data',[HeaderController::class,'fetchCategoryData']);

