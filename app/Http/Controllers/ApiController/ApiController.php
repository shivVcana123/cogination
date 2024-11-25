<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\HeaderResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\ServicesResource;
use App\Http\Resources\UsefullLinlsResource;
use App\Http\Resources\WebsiteStyleResource;
use App\Models\AboutUs;
use App\Models\Header;
use App\Models\Home;
use App\Models\News;
use App\Models\PageDesign;
use App\Models\Service;
use App\Models\UsefulLink;
use Illuminate\Http\Request;
use Str;

class ApiController extends Controller
{
    public function fetchHeaderData()
    {
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => HeaderResource::collection($headerData),
        ], 200);
    }
    public function fetchHomeData()
    {
        $homeData = Home::all();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => HomeResource::collection($homeData),
        ], 200);
    }
    public function fetchAboutData()
    {
        $aboutData = AboutUs::latest()->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => AboutResource::collection($aboutData),
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



}
