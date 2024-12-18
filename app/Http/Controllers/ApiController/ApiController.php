<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\HeaderResource;
use App\Http\Resources\HomeAppointmentResource;
use App\Http\Resources\HomeBringingHealthcareResource;
use App\Http\Resources\HomeFaqResource;
use App\Http\Resources\HomeOurServicesResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\HomeWhyChooseUsResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\ServicesResource;
use App\Http\Resources\UsefullLinlsResource;
use App\Http\Resources\WebsiteStyleResource;
use App\Models\AboutUs;
use App\Models\AboutUsJoinCommunity;
use App\Models\AboutUsOurMission;
use App\Models\AboutUsOurStory;
use App\Models\HomeBringingHealthcare;
use App\Models\Header;
use App\Models\Home;
use App\Models\News;
use App\Models\PageDesign;
use App\Models\Service;
use App\Models\UsefulLink;
use Illuminate\Http\Request;
use Str;
use App\Models\Contact;
use App\Models\Footer;
use App\Models\HomeAppointment;
use App\Models\HomeChooseUs;
use App\Models\HomeFaq;
use App\Models\HomeOurService;

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
        $aboutUsData = AboutUs::latest()->first();
        $ourStoryData = AboutUsOurStory::latest()->first();
        $ourMissionData = AboutUsOurMission::latest()->first();
        $joinCommunityData = AboutUsJoinCommunity::latest()->first();
    
        $data = [
            // 'aboutUsData' => $aboutUsData ? new AboutResource($aboutUsData) : null,
            'ourStoryData' => $ourStoryData ? new AboutResource($ourStoryData) : null,
            'ourMissionData' => $ourMissionData ? new AboutResource($ourMissionData) : null,
            // 'joinCommunityData' => $joinCommunityData ? new AboutResource($joinCommunityData) : null,
        ];
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $data,
        ], 200);
    }
    
    public function fetchServicesData()
    {
        $serviceData = Service::all();
    
        // Group the data by `service_type` and transform dynamically
        $groupedData = $serviceData->groupBy('service_type')->mapWithKeys(function ($services, $type) {
            // Generate a dynamic key by transforming the `service_type`
            $key = Str::slug($type, '_'); // Converts "Real Estate Consulting Service" to "real_estate_consulting_service"
            return [$key => ServicesResource::collection($services)];
        });
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $groupedData,
        ], 200);
    }
    
    

    public function fetchUsefullLinlsData()
    {
        $useFulLinkData = UsefulLink::all();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => UsefullLinlsResource::collection($useFulLinkData),
        ], 200);
    }
    public function fetchLatestNewsData()
    {
        $newsData = News::all();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => NewsResource::collection($newsData),
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


public function addContacts(Request $request)
{
    $pageDesign = new Contact();
    $pageDesign->email = $request->pageDesign;
    $pageDesign->name = $request->name;
    $pageDesign->subject = $request->subject;
    $pageDesign->message = $request->message;
    $pageDesign->save();
    return response()->json([
        'status' => 'success',
        'message' => 'Contact saved successfully',
        'data' => $pageDesign,
    ], 200);
}

}
