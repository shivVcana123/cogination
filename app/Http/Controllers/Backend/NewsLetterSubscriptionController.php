<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsLetterSubscriptionController extends Controller
{
    public function subscribeNewsletter()
    {
        $subscribeNewsletter = NewsletterSubscription::get();

        return view('news-lettere-email.index',compact('subscribeNewsletter'));
    }
}
