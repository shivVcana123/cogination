<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FeesOurPricing;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\News;
use App\Models\Header;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalServicesCount  = 0;
        $fees = FeesOurPricing::first();
        $services = json_decode($fees->pointers);
        foreach($services as $value){
            $sub_description = explode(',',$value->sub_description);
            $totalServicesCount += count($sub_description);
        }

        $pageCount = Header::where('link','!=','')->count();
        // dd($categories);
        return view("dashboard.dashboard",compact('totalServicesCount','pageCount'));
    }
}
