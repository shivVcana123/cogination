<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\AboutUsJoinCommunityResource;
use App\Http\Resources\AboutUsOurMissionResource;
use App\Http\Resources\AccreditationAccreditationResource;
use App\Http\Resources\AccreditationCertificationResource;
use App\Http\Resources\AccreditationOurCommitmentResource;
use App\Http\Resources\AccreditationSpecializedCertificationResource;
use App\Http\Resources\AdhdBenefitResource;
use App\Http\Resources\AdhdSecondSectionResource;
use App\Http\Resources\AdhdSectionResource;
use App\Http\Resources\AssessmentOurDiagnosticServiceResource;
use App\Http\Resources\AssessmentResource;
use App\Http\Resources\AssessmentUnderstandingConditionResource;
use App\Http\Resources\AssessmentWhyChooseResource;
use App\Http\Resources\AutismsBookResource;
use App\Http\Resources\AutismsProcessResource;
use App\Http\Resources\AutismsScreeningResource;
use App\Http\Resources\AutismsSecondSectionResource;
use App\Http\Resources\AutismsSectionResource;
use App\Http\Resources\FeesOurPricingResource;
use App\Http\Resources\FinancialResponsibilityResource;
use App\Http\Resources\HeaderResource;
use App\Http\Resources\HomeAboutUsDataResource;
use App\Http\Resources\HomeAppointmentResource;
use App\Http\Resources\HomeBringingHealthcareResource;
use App\Http\Resources\HomeFaqResource;
use App\Http\Resources\HomeOurServicesResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\HomeWhyChooseUsResource;
use App\Http\Resources\OurApproachHowItWorkResource;
use App\Http\Resources\OurApproachResource;
use App\Http\Resources\WebsiteStyleResource;
use App\Mail\NewsletterThankYou;
use App\Models\AboutUsJoinCommunity;
use App\Models\AboutUsOurMission;
use App\Models\AboutUsOurStory;
use App\Models\AccreditationAccreditation;
use App\Models\AccreditationCertification;
use App\Models\AccreditationOurCommitment;
use App\Models\AccreditationOurTeamContinuous;
use App\Models\AccreditationSpecializedCertification;
use App\Models\AdhdBenefit;
use App\Models\AdhdSecondSection;
use App\Models\AdhdSection;
use App\Models\Assessment;
use App\Models\AssessmentOurDiagnosticService;
use App\Models\AssessmentUnderstandingCondition;
use App\Models\AssessmentWhyChoose;
use App\Models\AutismsBook;
use App\Models\AutismsProcess;
use App\Models\AutismsScreening;
use App\Models\AutismsSecondSection;
use App\Models\AutismsSection;
use App\Models\BannerSection;
use App\Models\Cta;
use App\Models\HomeBringingHealthcare;
use App\Models\Header;
use App\Models\Home;
use App\Models\PageDesign;
use App\Traits\jsonResponse;
use Illuminate\Http\Request;
use App\Models\FeesOurPricing;
use App\Models\FinancialResponsibility;
use App\Models\Footer;
use App\Models\HomeAboutUsData;
use App\Models\HomeAppointment;
use App\Models\HomeChooseUs;
use App\Models\HomeFaq;
use App\Models\HomeOurService;
use App\Models\NewsLetterSection;
use App\Models\NewsletterSubscription;
use App\Models\OurApproach;
use App\Models\OurApproachHowItWork;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //use jsonResponse;
    public function fetchHeaderData()
    {
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        $footerData = Footer::latest()->first();
        $newslatter = NewsLetterSection::latest()->first();
        $ctaData = Cta::get();

        $data = [
            'data' => HeaderResource::collection($headerData),
            'footerData' => $footerData,
            'ctaData' => $ctaData,
            'newslatter' => $newslatter,
        ];




        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchHomeData()
    {
        $homeData = Home::all();
        $homeAboutUsData = HomeAboutUsData::latest()->first();
        $homeAppointmentData = HomeAppointment::latest()->first();
        $homeChooseUsData = HomeChooseUs::latest()->first();
        $homeOurServiceData = HomeOurService::latest()->first();
        $homeBringingHealthcareData = HomeBringingHealthcare::latest()->first();
        $footerData = Footer::latest()->first();
        $homeFaqData = HomeFaq::latest()->first();

        $data = [
            'heroSection' => HomeResource::collection($homeData),
            'homeAboutUsData' => $homeAboutUsData ? new HomeAboutUsDataResource($homeAboutUsData) : null,
            'appointmentSection' => $homeAppointmentData ? new HomeAppointmentResource($homeAppointmentData) : null,
            'whyChooseUs' => $homeChooseUsData ? new HomeWhyChooseUsResource($homeChooseUsData) : null,
            'ourService' => $homeOurServiceData ? new HomeOurServicesResource($homeOurServiceData) : null,
            'bringingHealthcare' => $homeBringingHealthcareData ? new HomeBringingHealthcareResource($homeBringingHealthcareData) : null,
            'footerData' => $footerData,
            'homeFaq' => $homeFaqData ? new HomeFaqResource($homeFaqData) : null,
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchAboutData()
    {
        $ourStoryData = AboutUsOurStory::latest()->first();
        $ourMissionData = AboutUsOurMission::latest()->first();
        $joinCommunityData = AboutUsJoinCommunity::latest()->first();

        $data = [
            // 'aboutUsData' => $aboutUsData ? new AboutResource($aboutUsData) : null,
            'ourStoryData' => $ourStoryData ? new AboutResource($ourStoryData) : null,
            'ourMissionData' => $ourMissionData ? new AboutUsOurMissionResource($ourMissionData) : null,
            'joinCommunityData' => $joinCommunityData ? new AboutUsJoinCommunityResource($joinCommunityData) : null,
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchOurApproachSectionData()
    {
        $ourApproachData = OurApproach::latest()->first();
        $ourApproachHowItWorkData = OurApproachHowItWork::latest()->first();

        $data = [
            // 'aboutUsData' => $aboutUsData ? new AboutResource($aboutUsData) : null,
            'ourApproach' => $ourApproachData ? new OurApproachResource($ourApproachData) : null,
            'ourApproachHowItWork' => $ourApproachHowItWorkData ? new OurApproachHowItWorkResource($ourApproachHowItWorkData) : null,
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchAccreditationSectionData()
    {
        $accreditationOurCommitmentData = AccreditationOurCommitment::latest()->first();
        $accreditationCertificationDate = AccreditationCertification::latest()->first();
        $accreditationAccreditationData = AccreditationAccreditation::latest()->first();
        $accreditationSpecializedCertificationDate = AccreditationSpecializedCertification::latest()->first();
        $accreditationOurTeamContinuousDate = AccreditationOurTeamContinuous::latest()->first();

        $data = [
            'accreditationOurCommitment' => $accreditationOurCommitmentData ? new AccreditationOurCommitmentResource($accreditationOurCommitmentData) : null,
            'accreditationCertification' => $accreditationCertificationDate ? new AccreditationCertificationResource($accreditationCertificationDate) : null,
            'accreditationAccreditation' => $accreditationAccreditationData ? new AccreditationAccreditationResource($accreditationAccreditationData) : null,
            'accreditationSpecializedCertification' => $accreditationSpecializedCertificationDate ? new AccreditationSpecializedCertificationResource($accreditationSpecializedCertificationDate) : null,
            'accreditationOurTeamContinuous' => $accreditationOurTeamContinuousDate ? new AccreditationOurCommitmentResource($accreditationOurTeamContinuousDate) : null,
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchAdhdSectionData()
    {
        $adhdSection = AdhdSection::all();
        $adhdSecondSection = AdhdSecondSection::all();
        $adhdBenefit = AdhdBenefit::all();
        // Group the data by `service_type` and transform dynamically
        $data = [
            'adhdSection' => AdhdSectionResource::collection($adhdSection),
            'adhdSecondSection' => AdhdSecondSectionResource::collection($adhdSecondSection),
            'adhdBenefit' => AdhdBenefitResource::collection($adhdBenefit),

        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchAutismSectionData()
    {
        $autismsSectionData = AutismsSection::all();
        $autismsSecondSectionData = AutismsSecondSection::all();
        $procesSectionData = AutismsProcess::all();
        $screeningSectionData = AutismsScreening::all();
        $bookSectionData = AutismsBook::all();

        $data = [
            'autismsSection' => AutismsSectionResource::collection($autismsSectionData),
            'autismsSecondSection' => AutismsSecondSectionResource::collection($autismsSecondSectionData),
            'procesSection' => AutismsProcessResource::collection($procesSectionData),
            'screeningSection' => AutismsScreeningResource::collection($screeningSectionData),
            'bookSection' => AutismsBookResource::collection($bookSectionData),
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchAssessmentSectionData()
    {
        $assessmentSectionData = Assessment::latest()->first();
        $diagnosticServiceSectionData = AssessmentOurDiagnosticService::latest()->first();
        $whyChooseSectionData = AssessmentWhyChoose::latest()->first();
        $understandingConditionSectionData = AssessmentUnderstandingCondition::latest()->first();


        $data = [
            'assessmentSection' => $assessmentSectionData ? new AssessmentResource($assessmentSectionData) : null,
            'diagnosticServiceSection' => $diagnosticServiceSectionData ? new AssessmentOurDiagnosticServiceResource($diagnosticServiceSectionData) : null,
            'whyChooseSection' => $whyChooseSectionData ? new AssessmentWhyChooseResource($whyChooseSectionData) : null,
            'understandingConditionSection' => $understandingConditionSectionData ? new AssessmentUnderstandingConditionResource($understandingConditionSectionData) : null,
        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchFeesSectionData(Request $request)
    {
        $feesOurPricingSectionData = FeesOurPricing::latest()->first();
        $financialResponsibilityData = FinancialResponsibility::latest()->first();
        $data = [
            'feesOurPricingSection' => $feesOurPricingSectionData ? new FeesOurPricingResource($feesOurPricingSectionData) : null,
            'financialResponsibility' => $financialResponsibilityData ? new FinancialResponsibilityResource($financialResponsibilityData) : null,

        ];


        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    public function fetchCtaSectionData()
    {
        $ctaData = Cta::get();
        // return $this->jsonResponse($ctaData);
        return response()->json([
            'status' => 'success',
            'message' => 'CSS styles fetched successfully',
            'data' =>  $ctaData,
        ], 200);
    }
    public function fetchBannerSectionData()
    {
        $bannerSection = BannerSection::get();
        //return $this->jsonResponse($bannerSection);
        return response()->json([
            'status' => 'success',
            'message' => 'CSS styles fetched successfully',
            'data' => $bannerSection,
        ], 200);
    }
    // public function fetchWebsiteStyle()
    // {
    //     $pageDesign = PageDesign::all();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'CSS styles fetched successfully',
    //         'data' => WebsiteStyleResource::collection($pageDesign),
    //     ], 200);
    // }
    // public function searchContent(Request $request)
    // {
    //     try {
    //         // Get the search query from the request
    //         $query = $request->query('search_');

    //         // If no query is provided, return an empty result
    //         if (!$query) {
    //             return response()->json([]);
    //         }

    //         // Define the models and their searchable columns
    //         $models = [
    //             HomeAboutUsData::class => ['title', 'description'],
    //             HomeAppointment::class => ['title', 'subtitle'],
    //             HomeChooseUs::class => ['title', 'description_1'],
    //             HomeOurService::class => ['title', 'description_1'],
    //             AdhdSection::class => ['first_title', 'first_description'],
    //             AdhdBenefit::class => ['title', 'description_1'],
    //             AutismsSection::class => ['first_title', 'first_description'],
    //             AutismsProcess::class => ['title', 'description'],
    //             AutismsScreening::class => ['title', 'description'],
    //             AutismsBook::class => ['title', 'description'],
    //             Assessment::class => ['title', 'description'],
    //             AssessmentOurDiagnosticService::class => ['title', 'description'],
    //             AssessmentWhyChoose::class => ['title', 'description'],
    //             AssessmentUnderstandingCondition::class => ['title', 'description'],
    //             FeesOurPricing::class => ['title', 'description'],
    //             FinancialResponsibility::class => ['title', 'description'],
    //             Cta::class => ['title', 'description'],
    //         ];

    //         $results = [];

    //         // Loop through the models and search each one
    //         foreach ($models as $model => $columns) {
    //             // Perform the search query on each model
    //             $modelResults = $model::query()
    //                 ->where(function ($queryBuilder) use ($columns, $query) {
    //                     foreach ($columns as $column) {
    //                         $queryBuilder->orWhere($column, 'LIKE', '%' . $query . '%')
    //                             ->whereNotNull($column);  // Ensure columns are not null
    //                     }
    //                 })
    //                 ->get(['id', ...$columns])  // Fetch columns with id
    //                 ->toArray();


    //             // Filter out any rows where values are null or 'undefined' (string)
    //             foreach ($modelResults as $result) {
    //                 $filteredResult = array_filter($result, function ($value) {
    //                     // Only include values that are not null or 'undefined' (string)
    //                     return !(is_null($value) || $value === 'undefined');
    //                 });

    //                 // Only add non-empty results to the final list
    //                 if (!empty($filteredResult)) {
    //                     $results[] = array_merge($filteredResult, ['model' => class_basename($model)]);
    //                 }
    //             }
    //         }

    //         // Return the results or a message if no matches are found
    //         return response()->json($results ?: ['message' => 'No matches found'], 200);
    //     } catch (\Exception $e) {
    //         // Log the error and return a generic message
    //         return response()->json([
    //             'message' => 'An error occurred while processing the search. Please try again later.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }


    public function searchContent(Request $request)
    {
        try {
            // Get the search query
            $query = $request->input('search_');
    
            // If no query is provided, return a message
            if (!$query) {
                return response()->json(['message' => 'Please enter a search term.'], 400);
            }
    
            // Define models and their searchable columns
            $models = [
                HomeAboutUsData::class => ['title', 'description', 'button_content','url','page'],
                HomeAppointment::class => ['title', 'subtitle', 'button_content','page','url'],
                HomeChooseUs::class => ['title', 'subtitle', 'pointers', 'description_1','page','url'],
                HomeOurService::class => ['title', 'subtitle', 'pointers', 'description_1','page','url'],
                HomeBringingHealthcare::class => ['title', 'subtitle', 'button_content1','page','url'],
                HomeFaq::class => ['title', 'subtitle', 'pointers','page','url'],
                AdhdSection::class => ['first_title', 'first_subtitle', 'first_button_content', 'first_description','page','url','type'],
                AdhdSecondSection::class => ['second_title', 'second_subtitle', 'second_description', 'pointers', 'heading','page','url','type'],
                AdhdBenefit::class => ['title', 'description_1', 'pointers', 'subtitle','page','url','type'],
                AutismsSection::class => ['first_title', 'first_subtitle', 'first_button_content', 'first_description','page','url','type'],
                AutismsSecondSection::class => ['second_title', 'second_subtitle', 'second_description', 'pointers','page','url','type'],
                AutismsProcess::class => ['title', 'subtitle', 'pointers', 'description','page','url','type'],
                AutismsScreening::class => ['title', 'subtitle', 'description', 'button_content','page','url','type'],
                AutismsBook::class => ['title', 'subtitle', 'description', 'button_content','page','url','type'],
                Assessment::class => ['title', 'subtitle', 'description', 'button_content','page','url'],
                AssessmentOurDiagnosticService::class => ['title', 'description', 'pointers','page','url'],
                AssessmentWhyChoose::class => ['title', 'subtitle', 'description', 'pointers', 'first_button_content', 'second_button_content','page','url'],
                AssessmentUnderstandingCondition::class => ['title', 'pointers', 'description','page','url'],
                FeesOurPricing::class => ['title', 'description', 'button_content', 'pointers','page','url'],
                FinancialResponsibility::class => ['title', 'description','page','url'],
                Cta::class => ['title', 'description', 'button_content','page','url','type'],
                AboutUsOurStory::class => ['title', 'subtitle', 'description', 'button_content','page','url'],
                AboutUsJoinCommunity::class => ['title', 'subtitle', 'description', 'pointers','page','url'],
                AboutUsOurMission::class => ['title','page','url'],
                AccreditationOurCommitment::class => ['title', 'description', 'button_content','page','url'],
                AccreditationAccreditation::class => ['title', 'subtitle', 'description', 'pointers','page','url'],
                AccreditationCertification::class => ['title', 'subtitle', 'description', 'pointers','page','url'],
                AccreditationOurTeamContinuous::class => ['title', 'button_content', 'description','page','url'],
                AccreditationSpecializedCertification::class => ['title', 'subtitle', 'pointers','page','url'],
                OurApproach::class => ['title', 'description','page','url'],
                OurApproachHowItWork::class => ['title', 'pointers','page','url'],
                BannerSection::class => ['heading', 'subtitle', 'description', 'button_text','page','url','section_type'],
            ];
    
            $results = [];
    
            // Loop through models and search
            // foreach ($models as $model => $columns) {    
            //     $modelResults = $model::query()
            //         ->where(function ($queryBuilder) use ($columns, $query) {
            //             foreach ($columns as $column) {
            //                 if ($column === 'pointers') {
            //                     $queryBuilder->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].sub_title')) LIKE ?", ["%$query%"])
            //                                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].sub_description')) LIKE ?", ["%$query%"])
            //                                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].pointerTitle')) LIKE ?", ["%$query%"])
            //                                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].pointerDescription')) LIKE ?", ["%$query%"])
            //                                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].second_sub_title')) LIKE ?", ["%$query%"])
            //                                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].second_sub_description')) LIKE ?", ["%$query%"]);
            //                 } else {
            //                     $queryBuilder->orWhere($column, 'LIKE', '%' . $query . '%')
            //                                  ->whereNotNull($column);
            //                 }
            //             }
            //         })
            //         ->get(array_merge(['id'], $columns))
            //         ->toArray();
    
            //     // Filter out null or 'undefined' values
            //     foreach ($modelResults as $result) {
            //         $filteredResult = array_filter($result, function ($value) {
            //             return !is_null($value) && $value !== 'undefined';
            //         });
    
            //         if (!empty($filteredResult)) {
            //             $results[] = array_merge($filteredResult, ['model' => class_basename($model)]);
            //         }
            //     }
            // }
            foreach ($models as $model => $columns) {    
                $modelResults = $model::query()
                    ->where(function ($queryBuilder) use ($columns, $query) {
                        foreach ($columns as $column) {
                            if ($column === 'pointers') {
                                $queryBuilder->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].sub_title')) LIKE ?", ["%$query%"])
                                             ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].sub_description')) LIKE ?", ["%$query%"])
                                             ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].pointerTitle')) LIKE ?", ["%$query%"])
                                             ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].pointerDescription')) LIKE ?", ["%$query%"])
                                             ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].second_sub_title')) LIKE ?", ["%$query%"])
                                             ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].second_sub_description')) LIKE ?", ["%$query%"]);


                                $queryBuilder->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].sub_pointer[*].pointerSubTitle1')) LIKE ?", ["%$query%"])
                                 ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($column, '$[*].sub_pointer[*].pointerSubDescription1')) LIKE ?", ["%$query%"]);
                                 
                            } else {
                                $queryBuilder->orWhere($column, 'LIKE', '%' . $query . '%')
                                             ->whereNotNull($column);
                            }
                        }
                    })
                    ->get(array_merge(['id'], $columns))
                    ->toArray();
            
                // Filter out null or 'undefined' values
                foreach ($modelResults as $result) {
                    $filteredResult = array_filter($result, function ($value) {
                        return !is_null($value) && $value !== 'undefined';
                    });
            
                    if (!empty($filteredResult)) {
                        $results[] = array_merge($filteredResult, ['model' => class_basename($model)]);
                    }
                }
            }
            
    
            // Return results or message if no matches
            return response()->json($results ?: ['message' => 'No matches found'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing the search. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function subscribeNewsletter(Request $request)
    {
        // dd($request->all());
        try {
            // Store the subscription in the database
            NewsletterSubscription::create([
                'email' => $request->email,
            ]);

            Mail::to($request->email)->send(new NewsletterThankYou($request->email));

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!',
            ], 200);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
