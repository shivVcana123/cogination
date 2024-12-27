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
use App\Http\Resources\AdhdSectionResource;
use App\Http\Resources\AssessmentOurDiagnosticServiceResource;
use App\Http\Resources\AssessmentResource;
use App\Http\Resources\AssessmentUnderstandingConditionResource;
use App\Http\Resources\AssessmentWhyChooseResource;
use App\Http\Resources\AutismsBookResource;
use App\Http\Resources\AutismsProcessResource;
use App\Http\Resources\AutismsScreeningResource;
use App\Http\Resources\AutismsSectionResource;
use App\Http\Resources\FeesOurPricingResource;
use App\Http\Resources\HeaderResource;
use App\Http\Resources\HomeAppointmentResource;
use App\Http\Resources\HomeBringingHealthcareResource;
use App\Http\Resources\HomeFaqResource;
use App\Http\Resources\HomeOurServicesResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\HomeWhyChooseUsResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\OurApproachHowItWorkResource;
use App\Http\Resources\OurApproachResource;
use App\Http\Resources\WebsiteStyleResource;
use App\Models\AboutUs;
use App\Models\AboutUsJoinCommunity;
use App\Models\AboutUsOurMission;
use App\Models\AboutUsOurStory;
use App\Models\AccreditationAccreditation;
use App\Models\AccreditationCertification;
use App\Models\AccreditationOurCommitment;
use App\Models\AccreditationOurTeamContinuous;
use App\Models\AccreditationSpecializedCertification;
use App\Models\AdhdBenefit;
use App\Models\AdhdSection;
use App\Models\Assessment;
use App\Models\AssessmentOurDiagnosticService;
use App\Models\AssessmentUnderstandingCondition;
use App\Models\AssessmentWhyChoose;
use App\Models\AutismsBook;
use App\Models\AutismsProcess;
use App\Models\AutismsScreening;
use App\Models\AutismsSection;
use App\Models\HomeBringingHealthcare;
use App\Models\Header;
use App\Models\Home;
use App\Models\News;
use App\Models\PageDesign;
use Illuminate\Http\Request;
use Str;
use App\Models\Contact;
use App\Models\FeesOurPricing;
use App\Models\Footer;
use App\Models\HomeAppointment;
use App\Models\HomeChooseUs;
use App\Models\HomeFaq;
use App\Models\HomeOurService;
use App\Models\OurApproach;
use App\Models\OurApproachHowItWork;

class ApiController extends Controller
{
    public function fetchHeaderData()
    {
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        $footerData = Footer::get();

        $data = [
            'data' => HeaderResource::collection($headerData),
            'footerData' => $footerData,
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
        $homeAppointmentData = HomeAppointment::all();
        $homeChooseUsData = HomeChooseUs::all();
        $homeOurServiceData = HomeOurService::all();
        $homeBringingHealthcareData = HomeBringingHealthcare::all();
        $footerData = Footer::get();
        $homeFaqData = HomeFaq::all();

        $data = [
            'heroSection' => HomeResource::collection($homeData),
            'appointmentSection' => HomeAppointmentResource::collection($homeAppointmentData),
            'whyChooseUs' => HomeWhyChooseUsResource::collection($homeChooseUsData),
            'ourService' => HomeOurServicesResource::collection($homeOurServiceData),
            'bringingHealthcare' => HomeBringingHealthcareResource::collection($homeBringingHealthcareData),
            'footerData' =>$footerData,
            'homeFaq' => HomeFaqResource::collection($homeFaqData),
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
        $adhdBenefit = AdhdBenefit::all();
        // Group the data by `service_type` and transform dynamically
        $data = [
            'adhdSection' => AdhdSectionResource::collection($adhdSection),
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
        $procesSectionData = AutismsProcess::all();
        $screeningSectionData = AutismsScreening::all();
        $bookSectionData = AutismsBook::all();

        $data = [
            'autismsSection' => AutismsSectionResource::collection($autismsSectionData),
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
        $assessmentSectionData = Assessment::all();
        $diagnosticServiceSectionData = AssessmentOurDiagnosticService::all();
        $whyChooseSectionData = AssessmentWhyChoose::all();
        $understandingConditionSectionData = AssessmentUnderstandingCondition::all();


        $data = [
            'assessmentSection' => AssessmentResource::collection($assessmentSectionData),
            'diagnosticServiceSection' => AssessmentOurDiagnosticServiceResource::collection($diagnosticServiceSectionData),
            'whyChooseSection' => AssessmentWhyChooseResource::collection($whyChooseSectionData),
            'understandingConditionSection' => AssessmentUnderstandingConditionResource::collection($understandingConditionSectionData),
        ];
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' =>$data, 
        ], 200);
    }


    public function fetchFeesSectionData(Request $request)
{
    $feesOurPricingSectionData = FeesOurPricing::get();
    $data =[
        'feesOurPricingSection' => FeesOurPricingResource::collection($feesOurPricingSectionData),
    ];
    return response()->json([
        'status' => 'success',
        'message' => 'Data fetched successfully',
        'data' => $data,
    ], 200);
}

public function fetchWebsiteStyle()
{
    $pageDesign = PageDesign::all();
    return response()->json([
        'status' => 'success',
        'message' => 'CSS styles fetched successfully',
        'data' => WebsiteStyleResource::collection($pageDesign),
    ], 200);
}




}
