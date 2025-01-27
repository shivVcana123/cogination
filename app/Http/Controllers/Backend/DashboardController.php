<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;
use App\Models\Header;
use App\Models\FeesOurPricing;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalServicesCount = 0;
        $fees = FeesOurPricing::first();
        $services = json_decode($fees->pointers);
        foreach ($services as $value) {
            $sub_description = explode(',', $value->sub_description);
            $totalServicesCount += count($sub_description);
        }

        $pageCount = Header::where('link', '!=', '')->count();
        $newsLetterCount = NewsletterSubscription::count();

        return view("dashboard.dashboard", compact('totalServicesCount', 'pageCount', 'newsLetterCount'));
    }

    public function getRecentNewsletterSubscriptions(Request $request)
    {
        $filterType = $request->input('filter', 'month'); // Default filter is 'month'
        $query = NewsletterSubscription::query();

        if ($filterType === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filterType === 'month') {
            $query->whereYear('created_at', now()->year)
                  ->whereMonth('created_at', now()->month);
        } elseif ($filterType === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $subscriptions = $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                               ->groupBy('year', 'month')
                               ->orderBy('year', 'asc')
                               ->orderBy('month', 'asc')
                               ->get();

        return response()->json($subscriptions);
    }
}
