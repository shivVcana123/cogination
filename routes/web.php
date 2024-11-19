<?php

use App\Http\Controllers\ApiController\HomeController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\NewsController;
use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use  App\Http\Controllers\Backend\AuthController;
    use  App\Http\Controllers\Backend\DashboardController;
    use  App\Http\Controllers\Backend\HeaderController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use  App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\UsefullLinkController;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', function () {
            return view('login');
        });
        Route::post('/login', [AuthController::class, 'login'])->name('login');    
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::get('/chage-password', [AuthController::class, 'changePassword'])->name('changePassword');
        Route::post('/chage-password', [AuthController::class, 'saveChangePassword'])->name('saveChangePassword');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::get('logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout'); 
    // Route::get('/header', [HeaderController::class, 'header'])->name('header'); // Add or Update header data
    // Route::get('/add-header', [HeaderController::class, 'addheader'])->name('addheader'); // Add or Update header data

    
    // Route::post('/save-header', [HeaderController::class, 'addOrUpdateHeader'])->name('addOrUpdateHeader'); // Add or Update header data

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::resource('header', HeaderController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('home', BackendHomeController::class);
    Route::resource('about', AboutController::class);
    Route::resource('news', NewsController::class);
    Route::resource('link', UsefullLinkController::class);
    use Illuminate\Support\Facades\Artisan;

    Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        return response()->json([
            'status' => 'success',
            'message' => 'Application cache cleared successfully.',
        ]);
    });
    
