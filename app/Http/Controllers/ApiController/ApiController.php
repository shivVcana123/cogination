<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\HeaderResource;
use App\Http\Resources\HomeResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\ServicesResource;
use App\Http\Resources\UsefullLinlsResource;
use App\Models\AboutUs;
use App\Models\Header;
use App\Models\Home;
use App\Models\News;
use App\Models\Service;
use App\Models\UsefulLink;
use Illuminate\Http\Request;

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
        $aboutData = AboutUs::all();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => AboutResource::collection($aboutData),
        ], 200);
    }
    public function fetchServicesData()
    {
        $serviceData = Service::all();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => ServicesResource::collection($serviceData),
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
}
