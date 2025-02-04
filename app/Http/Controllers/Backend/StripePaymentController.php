<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
     
     public function createCheckoutSession(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $request->priceId, // Use the price ID from Stripe dashboard
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'https://cognition-demo.vercel.app/success',
                'cancel_url' => 'https://cognition-demo.vercel.app/cancel',
            ]);

            return response()->json(['checkout_url' => $session->url], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


  

}
