<?php

use App\Http\Controllers\ApiController\HomeController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AboutUsController;
use App\Http\Controllers\Backend\AccreditationController;
use App\Http\Controllers\backend\AdhdBenefitsController;
use App\Http\Controllers\Backend\AssessmentController;
use App\Http\Controllers\Backend\NewsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BannerController;
// use App\Http\Controllers\Backend\AutismSectionController;
use App\Http\Controllers\backend\AutismsSectionController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FeesController;
use App\Http\Controllers\Backend\HeaderController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\CtaController;
use App\Http\Controllers\Backend\PageDesignController;
use App\Http\Controllers\Backend\FooterController;
use App\Http\Controllers\Backend\HomeSectionControoler;
use App\Http\Controllers\Backend\OurApproachController;
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
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    

    Route::get('/change-logo', [AuthController::class, 'changeLogo'])->name('changeLogo');
    Route::post('/save-change-logo', [AuthController::class, 'saveChangeLogo'])->name('saveChangeLogo');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');

    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::post('/saveChangePassword', [AuthController::class, 'saveChangePassword'])->name('saveChangePassword');
        // Resource Routes
    Route::resource('header', HeaderController::class);
    Route::resource('home', BackendHomeController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('page', PageDesignController::class);
    Route::resource('cta', CtaController::class);

    Route::get('/saveDesign', [PageDesignController::class, 'saveDesign'])->name('saveDesign');

    // footer section Route
    Route::get('footer', [FooterController::class,'footer'])->name('footer');
    Route::post('save-footer', [FooterController::class,'saveFooter'])->name('save-footer');
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

    
    Route::get('home-about', [HomeSectionControoler::class, 'homeAbout'])->name('homeAbout');
    Route::post('save-home-about', [HomeSectionControoler::class, 'saveHomeAbout'])->name('saveHomeAbout');

    // ADHD section Route
    Route::get('adhd-benefits', [AdhdBenefitsController::class, 'adhdBenefits'])->name('adhd-benefits');
    Route::post('save-adhd-benefits', [AdhdBenefitsController::class, 'saveAdhdBenefits'])->name('save-adhd-benefits');
    Route::get('/fetch-adhd-benefits-section-by-type', [AdhdBenefitsController::class, 'fetchAdhdBenefitSectionByType'])->name('fetch-adhd-benefits-section-by-type');

    Route::get('adhd-section', [AdhdBenefitsController::class, 'adhdSection'])->name('adhd-section');
    Route::get('/fetch-adhd-section-by-type', [AdhdBenefitsController::class, 'fetchAdhdSectionByType'])->name('fetch-adhd-section-by-type');
    Route::post('save-adhd-section', [AdhdBenefitsController::class, 'saveAdhdSection'])->name('save-adhd-section');

    // Autism section Route
    Route::get('autism-section', [AutismsSectionController::class, 'autismSection'])->name('autism-section');
    Route::post('save-autism-section', [AutismsSectionController::class, 'saveAutismSection'])->name('save-autism-section');
    Route::get('/fetch-autism-section-by-type', [AutismsSectionController::class, 'fetchAutismsSectionByType'])->name('fetch-autism-section-by-type');
    Route::get('autism-process', [AutismsSectionController::class, 'autismProcessSection'])->name('autism-process-section');
    Route::post('save-process-section', [AutismsSectionController::class, 'saveProcessSection'])->name('save-process-section');
    Route::get('/fetch-process-section-by-type', [AutismsSectionController::class, 'fetchAutismsProcessSectionByType'])->name('fetch-process-section-by-type');

    Route::get('autism-screening', [AutismsSectionController::class, 'autismScreeningSection'])->name('autism-screening-section');
    Route::post('save-screening-section', [AutismsSectionController::class, 'saveScreeningSection'])->name('save-screening-section');
    Route::get('/fetch-screening-section-by-type', [AutismsSectionController::class, 'fetchAutismsScreeningSectionByType'])->name('fetch-screening-section-by-type');

    Route::get('autism', action: [AutismsSectionController::class, 'autism'])->name('autism');
    Route::get('form', action: [AutismsSectionController::class, 'form'])->name('form');
    Route::post('save-form', action: [AutismsSectionController::class, 'saveform'])->name('save-form');
    Route::get('autism-index', [AutismsSectionController::class, 'autismIndex'])->name('autism-index');


    

    Route::get('autism-book', [AutismsSectionController::class, 'autismBookSection'])->name('autism-book-section');
    Route::post('save-book-section', [AutismsSectionController::class, 'saveBookSection'])->name('save-book-section');
    Route::get('/fetch-book-section-by-type', [AutismsSectionController::class, 'fetchAutismsBookSectionByType'])->name('fetch-book-section-by-type');

    // Assessment section Route
    Route::get('assessment-section', [AssessmentController::class, 'assessmentSection'])->name('assessment-section');
    
    Route::post('save-assessment', [AssessmentController::class, 'saveAssessmentSection'])->name('save-assessment');

    Route::get('assessment-whychoose', [AssessmentController::class, 'assessmentWhychooseSection'])->name('assessment-whychoose-section');
    Route::post('save-whychoose-section', [AssessmentController::class, 'saveWhychooseSection'])->name('save-whychoose-section');

    Route::get('our-diagnostic-services', [AssessmentController::class, 'assessmentOurDiagnosticServicesSection'])->name('assessment-our-diagnostic-services-section');
    Route::post('save-our-diagnostic-services', [AssessmentController::class, 'saveOurDiagnosticServices'])->name('save-our-diagnostic-services');

    Route::get('understanding-conditions', [AssessmentController::class, 'understandingConditionsSection'])->name('understanding-conditions-section');
    Route::post('save-understanding-conditions', [AssessmentController::class, 'saveUnderstandingConditions'])->name('save-understanding-conditions');


    // Fees section Route
    Route::get('our-pricing-section', [FeesController::class, 'ourPricingSection'])->name('our-pricing-section');
    Route::post('save-our-pricing-section', [FeesController::class, 'saveOurPricingSection'])->name('save-our-pricing-section');


     // About Us section Route
     Route::get('our-story-section', [AboutUsController::class, 'ourStorySection'])->name('our-story-section');
     Route::post('save-our-story-section', [AboutUsController::class, 'saveOurStorySection'])->name('save-our-story-section');

     Route::get('our-mission-section', [AboutUsController::class, 'ourMissionSection'])->name('our-mission-section');
     Route::post('save-our-mission-section', [AboutUsController::class, 'saveOurMissionSection'])->name('save-our-mission-section');

     Route::get('join-community-section', [AboutUsController::class, 'joinCommunitySection'])->name('join-community-section');
     Route::post('save-join-community-section', [AboutUsController::class, 'savejoinCommunitySection'])->name('save-join-community-section');

      // Our Approach section Route
      Route::get('our-approach', [OurApproachController::class, 'ourApproachSection'])->name('our-approach-section');
      Route::post('save-our-approach', [OurApproachController::class, 'saveOurApproachSection'])->name('save-our-approach-section');

      Route::get('how-it-works', [OurApproachController::class, 'howItWorksSection'])->name('how-it-works-section');
      Route::post('save-how-it-works', [OurApproachController::class, 'savehowItWorksSection'])->name('save-how-it-works-section');

    // Accreditation & Certifications section Route
    Route::get('our-commitment', [AccreditationController::class, 'ourCommitmentSection'])->name('our-commitment-section');
    Route::post('save-our-commitment', [AccreditationController::class, 'saveOurCommitmentSection'])->name('save-our-commitment-section');

    Route::get('certifications-section', [AccreditationController::class, 'certificationsSection'])->name('certifications-section');
    Route::post('save-certifications', [AccreditationController::class, 'saveCertificationsSection'])->name('save-certifications-section');

    Route::get('accreditations-section', [AccreditationController::class, 'accreditationsSection'])->name('accreditations-section');
    Route::post('save-accreditations', [AccreditationController::class, 'saveAccreditationsSection'])->name('save-accreditations-section');

    Route::get('specialized-certifications-section', [AccreditationController::class, 'specializedCertificationsSection'])->name('specialized-certifications-section');
    Route::post('save-specialized-certifications', [AccreditationController::class, 'saveSpecializedCertifications'])->name('save-specialized-certification-section');

    Route::get('our-team-continuous-section', [AccreditationController::class, 'ourTeamContinuousSection'])->name('our-team-continuous-section');
    Route::post('save-our-team-continuous', [AccreditationController::class, 'saveOurTeamContinuousSection'])->name('save-our-team-continuous-section');

});


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


