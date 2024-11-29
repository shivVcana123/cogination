<?php

use App\Http\Controllers\ApiController\HomeController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\backend\AdhdBenefitsController;
use App\Http\Controllers\Backend\NewsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HeaderController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\UsefullLinkController;
use App\Http\Controllers\Backend\PageDesignController;
use App\Http\Controllers\Backend\FooterController;
use App\Http\Controllers\Backend\HomeSectionControoler;
use Illuminate\Support\Facades\Artisan;

Route::get('/welcome', function () {
    return view('welcome');
});


// Guest Middleware Group
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Auth Middleware Group
// Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');

    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::post('/saveChangePassword', [AuthController::class, 'saveChangePassword'])->name('saveChangePassword');
        // Resource Routes
    Route::resource('header', HeaderController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('home', BackendHomeController::class);
    Route::resource('about', AboutController::class);
    Route::resource('news', NewsController::class);
    Route::resource('link', UsefullLinkController::class);
    Route::resource('page', PageDesignController::class);
    Route::resource('footer', FooterController::class);

    // Home section Route
    Route::get('appointment', [HomeSectionControoler::class, 'appointment'])->name('appointment');
    Route::post('save-appointment', [HomeSectionControoler::class, 'saveappointment'])->name('save-appointment');
    Route::get('our-services', [HomeSectionControoler::class, 'ourservices'])->name('our-services');
    Route::post('save-our-services', [HomeSectionControoler::class, 'saveourservices'])->name('save-our-services');
    Route::get('whychooseus', [HomeSectionControoler::class, 'whychooseus'])->name('whychooseus');
    Route::post('save-whychooseus', [HomeSectionControoler::class, 'savewhychooseus'])->name('save-whychooseus');
    Route::get('bringinghealthcare', [HomeSectionControoler::class,'bringinghealthcare'])->name('bringinghealthcare');
    Route::post('save-bringinghealthcare', [HomeSectionControoler::class, 'savebringinghealthcare'])->name('save-bringinghealthcare');
    Route::get('faqs', [HomeSectionControoler::class, 'faqs'])->name('faqs');
    Route::post('save-faq', [HomeSectionControoler::class, 'saveFaqs'])->name('save-faq');

    // ADHD section Route
    Route::get('adhd-benefits', [AdhdBenefitsController::class, 'adhdBenefits'])->name('adhd-benefits');
    Route::post('save-adhd-benefits', [AdhdBenefitsController::class, 'saveAdhdBenefits'])->name('save-adhd-benefits');

    Route::get('adhd-first-section', [AdhdBenefitsController::class, 'adhdFirstSection'])->name('adhd-first-section');
    Route::get('/fetch-adhd-section-by-type', [AdhdBenefitsController::class, 'fetchAdhdSectionByType'])->name('fetch-adhd-section-by-type');

    Route::post('save-first-section', [AdhdBenefitsController::class, 'saveAdhdFirstSection'])->name('save-first-section');

    Route::get('adhd-second-section', [AdhdBenefitsController::class, 'adhdSecondSection'])->name('adhd-second-section');
    Route::post('save-second-section', [AdhdBenefitsController::class, 'saveAdhdSecondSection'])->name('save-second-section');

    Route::post('/website-style', [PageDesignController::class, 'store'])->name('website-style');
// });


// Database Migration Route
Route::get('/header-seeder', function () {
    try {
        Artisan::call('db:seed');
        return response()->json([
            'status' => 'success',
            'message' => 'Database seed executed successfully.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to run seed: ' . $e->getMessage(),
        ], 500);
    }
});

// Database Migration Route
Route::get('/migrate', function () {
    try {
        Artisan::call('migrate');
        return response()->json([
            'status' => 'success',
            'message' => 'Database migrations executed successfully.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to run migrations: ' . $e->getMessage(),
        ], 500);
    }
});

// Clear Cache Route
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return response()->json([
        'status' => 'success',
        'message' => 'Application cache cleared successfully.',
    ]);
})->name('clear.cache');


