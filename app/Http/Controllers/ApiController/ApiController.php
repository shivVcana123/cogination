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
use App\Models\PageDesign;
use App\Traits\jsonResponse;
use Illuminate\Http\Request;
use App\Models\FeesOurPricing;
use App\Models\Footer;
use App\Models\HomeAboutUsData;
use App\Models\HomeAppointment;
use App\Models\HomeChooseUs;
use App\Models\HomeFaq;
use App\Models\HomeOurService;
use App\Models\OurApproach;
use App\Models\OurApproachHowItWork;

class ApiController extends Controller
{
    use jsonResponse;
    public function fetchHeaderData()
    {
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        $footerData = Footer::get();

        $data = [
            'data' => HeaderResource::collection($headerData),
            'footerData' => $footerData,
        ];

        return $this->jsonResponse($data);


        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
    }

    public function fetchAssessmentSectionData()
    {
        $assessmentSectionData = Assessment::latest()->first();
        $diagnosticServiceSectionData = AssessmentOurDiagnosticService::latest()->first();
        $whyChooseSectionData = AssessmentWhyChoose::latest()->first();
        $understandingConditionSectionData = AssessmentUnderstandingCondition::latest()->first();


        $data = [
            'assessmentSection' => $assessmentSectionData ? new AssessmentResource($assessmentSectionData) : null,
            'diagnosticServiceSection' => $diagnosticServiceSectionData? new AssessmentOurDiagnosticServiceResource($diagnosticServiceSectionData) : null,
            'whyChooseSection' => $whyChooseSectionData ? new AssessmentWhyChooseResource($whyChooseSectionData) : null,
            'understandingConditionSection' => $understandingConditionSectionData ? new AssessmentUnderstandingConditionResource($understandingConditionSectionData) : null,
        ];

        return $this->jsonResponse($data);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
    }

    public function fetchFeesSectionData(Request $request)
    {
        $feesOurPricingSectionData = FeesOurPricing::latest()->first();
        $data = [
            'feesOurPricingSection' => $feesOurPricingSectionData ? new FeesOurPricingResource($feesOurPricingSectionData) : null,
        ];
        return $this->jsonResponse($data);

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data fetched successfully',
        //     'data' => $data,
        // ], 200);
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
