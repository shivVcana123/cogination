<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\News;
use App\Models\Header;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $services = User::all();
        $news = User::all();
        $categories = Header::all();

        return view("dashboard.dashboard",compact('users','services','news','categories'));
    }
}
