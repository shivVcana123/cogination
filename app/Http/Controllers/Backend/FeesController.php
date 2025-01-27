<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\FeesOurPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class FeesController extends Controller
{
    protected $stripe;

    public function __construct(){
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }
    public function financialResponsibilities()
    {
        $finance = DB::table('financial_responsibilities')->first();
        return view('fees-section.financial-responsibility',compact('finance'));

    }
    public function financialSaveResponsibilities(Request $request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? "off",
        ];
    
        if ($request->id) {
            // Update existing record
            DB::table('financial_responsibilities')
                ->where('id', $request->id)
                ->update($data);
        } else {
           DB::table('financial_responsibilities')->insertGetId($data);
        }
    
        // Fetch the record
        $finance = DB::table('financial_responsibilities')->first();
    
        // Return view with data
        return view('fees-section.financial-responsibility', compact('finance'));

    }
   

    public function ourPricingSection(){
        $ourPricing = FeesOurPricing::get();
        return view('fees-section.ourpricing',compact('ourPricing'));
    }


    // public function saveOurPricingSection(Request $request)
    // {
    //     dd($request->all());
    
    //     try {
    //         // Validate request data
    //         $validated = $request->validate([
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'sub_title' => 'array',
    //             'sub_title.*' => 'nullable|string|max:255',
    //             'sub_description' => 'array', // Ensure sub_description is an array
    //             'sub_description.*' => 'array', // Each element of sub_description must be an array
    //             'sub_description.*.*' => 'nullable|string', // Each item inside the sub_description array must be a string or null
    //             'price.*' => 'array', // Each element of sub_description must be an array
    //             'price.*.*' => 'nullable|string', 
    //         ]);
            

            
    //         // Fetch or create a new section
    //         $autismSection = $request->id
    //             ? FeesOurPricing::find($request->id)
    //             : new FeesOurPricing();
    
    //         // Handle pointers (sub_title, sub_description, child_description)
    //         $pointers = [];
    
    //         // Loop through sub_titles
    //         foreach ($request->input('sub_title', []) as $index => $subTitle) {
    //             // Collect all sub_descriptions for the current index
    //             $subDescriptions = $request->input("sub_description.{$index}", []);
    //             $price = $request->input("price.{$index}", []);
    //             // Ensure $subDescriptions is an array and join them
    //             $pointers[] = [
    //                 'sub_title' => $subTitle,
    //                 'sub_description' => is_array($subDescriptions) 
    //                     ? implode(',', $subDescriptions) 
    //                     : $subDescriptions,
    //                     'price' => is_array($price) 
    //                     ? implode(',', $price) 
    //                     : $price,
    //             ];
    //         }
    
    //         // Assign validated data to the model
    //         $autismSection->title = $validated['title'];
    //         $autismSection->description = $validated['description'];
    //         $autismSection->status = $request->status ?? "off";
    //         $autismSection->pointers = json_encode($pointers);
    
    //         // Save the record
    //         $autismSection->save();
    
    //         // Success redirect
    //         return redirect()->route('our-pricing-section')->with('success', 'Pricing section saved successfully.');
    
    //     } catch (\Exception $e) {
    //         dd($e);
    //         // Handle any exceptions (validation, database, etc.)
    //         return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    //     }
    // }
    

    public function saveOurPricingSection(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'sub_title.*' => 'required',
            'sub_description.*.*' => 'required',
            'price.*.*' => 'required|numeric',
        ], [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'sub_title.*.required' => 'The sub title field is required.',
            'sub_description.*.*.required' => 'The sub description field is required.',
            'price.*.*.required' => 'The price field is required.',
            'price.*.*.numeric' => 'Each price must be a valid number.',
        ]);
        try {
            // Fetch or create a new record
            $autismSection = $request->id
                ? FeesOurPricing::find($request->id)
                : new FeesOurPricing();
        
            // Handle pointers (sub_title, sub_description, price)
            $pointers = [];
           
            // Loop through sub_titles
            foreach ($request->input('sub_title', []) as $index => $subTitle) {
                // Collect all sub_descriptions and prices for the current index
                $subDescriptions = $request->input("sub_description.{$index}", []);
                $prices = $request->input("price.{$index}", []);
        
                // Initialize an array to store multiple price IDs for the current entry
                $priceIds = [];
        
                // Loop through each price and create a Stripe price
                foreach ($prices as $price) {
                    $stripePrice = $this->stripe->prices->create([
                        'currency' => env('CURRENCY'),
                        'unit_amount' => $price * 100, // Convert price to cents
                        'product' => env('PRODUCT_ONE_TIME_ID'),
                        'nickname' => env('NICKNAME_TITLE'),
                    ]);
        
                    // Collect the Stripe price ID
                    $priceIds[] = $stripePrice->id;
                }
        
                // Convert the price_ids array to a comma-separated string
                $priceIdsString = implode(',', $priceIds);
        
                // Prepare the pointers array
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => is_array($subDescriptions) 
                        ? implode(',', $subDescriptions) 
                        : $subDescriptions,
                    'price' => is_array($prices) 
                        ? implode(',', $prices) 
                        : $prices,
                    'price_id' => $priceIdsString, // Store the price IDs as a comma-separated string
                ];
            }
        
            // Assign data to the model
            $autismSection->title = $request->title;
            $autismSection->description = $request->description;
            $autismSection->status = $request->status ?? "off";
            $autismSection->pointers = json_encode($pointers);
        
            // Save the record
            $autismSection->save();
        
            // Success redirect
            return redirect()->route('our-pricing-section')->with('success', 'Pricing section saved successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle any exceptions
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
        
     }
    
//     public function saveOurPricingSection(Request $request)
// {
//     // Validation rules
//     $validatedData = $request->validate([
//         'title' => 'required',
//         'description' => 'required',
//         'sub_title.*' => 'required',
//         'sub_description.*.*' => 'required',
//         'price.*.*' => 'required|numeric',
//     ], [
//         'title.required' => 'The title field is required.',
//         'description.required' => 'The description field is required.',
//         'sub_title.*.required' => 'The sub title field is required.',
//         'sub_description.*.*.required' => 'The sub description field is required.',
//         'price.*.*.required' => 'The price field is required.',
//         'price.*.*.numeric' => 'Each price must be a valid number.',
//     ]);
//     try {
//         // Fetch or create a new record
//         $autismSection = $request->id
//             ? FeesOurPricing::find($request->id)
//             : new FeesOurPricing();

//         // Handle pointers (sub_title, sub_description, price)
//         $pointers = [];
       
//         // Loop through sub_titles
//         foreach ($request->input('sub_title', []) as $index => $subTitle) {
//             // Collect all sub_descriptions and prices for the current index
//             $subDescriptions = $request->input("sub_description.{$index}", []);
//             $price = $request->input("price.{$index}",  []);
   
            
//             $stripePrice = $this->stripe->prices->create([
//                 'currency' => env('CURRENCY'),
//                 'unit_amount' => $price[0] * 100,
//                 'product' => env('PRODUCT_ONE_TIME_ID'),
//                 'nickname' => env('NICKNAME_TITLE'),
//             ]);

            
          
//             // Prepare the pointers array
//             $pointers[] = [
//                 'sub_title' => $subTitle,
//                 'sub_description' => is_array($subDescriptions) 
//                     ? implode(',', $subDescriptions) 
//                     : $subDescriptions,
//                 'price' => is_array($price) 
//                     ? implode(',', $price) 
//                     : $price,
//                 'price_id'=>$stripePrice->id,
//             ];

//             // dd($pointers);
//         }

//         // Assign data to the model
//         $autismSection->title = $request->title;
//         $autismSection->description = $request->description;
//         $autismSection->status = $request->status ?? "off";
//         $autismSection->pointers = json_encode($pointers);

//         // Save the record
//         $autismSection->save();

//         // Success redirect
//         return redirect()->route('our-pricing-section')->with('success', 'Pricing section saved successfully.');
//     } catch (\Exception $e) {
//         dd($e->getMessage());
//         // Handle any exceptions
//         return redirect()->back()->withErrors(['error' => $e->getMessage()]);
//     }
//  }
// public function checkoutPurchase(Request $request, string $plan)
//     {
//         dd($request->all());
        
//         // $stripePriceId = $plan;

//         // $quantity = 1;
        
//         //     // Proceed with checkout
//         //     return $request->user()->checkout([$stripePriceId => $quantity],[
//         //         'success_url' => route('dashboard', [
//         //             'success' => 'Congratulations! You have successfully purchased.',
//         //             'plan'=>$stripePriceId,
//         //         ]),
//         //         'cancel_url' => route('dashboard', [
//         //             'error' => 'Something went wrong!!'
//         //         ]),
//         //     ]);
        
//     }

    public function checkoutPurchase(Request $request, string $plan)
    {
        // Define Stripe price ID
        $stripePriceId = $plan;

        // Set quantity (e.g., 1 for one subscription or item)
        $quantity = 1;

        // Ensure the user is authenticated
        $user = $request->user();
        dd($user);
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Use Stripe's checkout method
        return $user->checkout([$stripePriceId => $quantity], [
            'success_url' => route('dashboard', [
                'success' => 'Congratulations! You have successfully purchased.',
                'plan' => $stripePriceId,
            ]),
            'cancel_url' => route('dashboard', [
                'error' => 'Something went wrong!',
            ]),
        ]);
    }
}
