<?php
use App\Http\Controllers\ApiController\ApiController;
use App\Http\Controllers\Backend\FeesController;
use App\Http\Controllers\Backend\PageDesignController;
use App\Http\Controllers\Backend\StripePaymentController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetch-header-data', [ApiController::class, 'fetchHeaderData']); // Fetch all header data
Route::get('hero-section', [ApiController::class, 'fetchHomeData']); // Fetch all header data
Route::get('adhd-section', [ApiController::class, 'fetchAdhdSectionData']); // Fetch all header data
Route::get('autism-section', [ApiController::class, 'fetchAutismSectionData']); // Fetch all header data
Route::get('assessment-section', [ApiController::class, 'fetchAssessmentSectionData']); // Fetch all header data
Route::get('fees-section', [ApiController::class, 'fetchFeesSectionData']); // Fetch all website-style data
Route::get('about-us-section', [ApiController::class, 'fetchAboutData']); // Fetch all header data
Route::get('our-approach-section', [ApiController::class, 'fetchOurApproachSectionData']); // Fetch all header data
Route::get('accreditation-section', [ApiController::class, 'fetchAccreditationSectionData']); // Fetch all header data
Route::get('website-style', [ApiController::class, 'fetchWebsiteStyle']); // Fetch all website-style data
Route::get('cta-section', [ApiController::class, 'fetchCtaSectionData']); // Fetch all website-style data
Route::get('banner-section', [ApiController::class, 'fetchBannerSectionData']); // Fetch all website-style data
Route::get('search-content', [ApiController::class, 'searchContent']);
Route::post('/create-checkout-session', [StripePaymentController::class, 'createCheckoutSession']);
Route::post('/subscribe-newsletter', [ApiController::class, 'subscribeNewsletter']);
Route::post('/checkout', [WebhookController::class,'handleWebhook']);

