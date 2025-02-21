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

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function financialResponsibilities()
    {
        $finance = DB::table('financial_responsibilities')->first();
        return view('fees-section.financial-responsibility', compact('finance'));
    }
    
    public function financialSaveResponsibilities(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:100|max:2000',
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? "off",
            'url' => "fee",
            'page' => "Fees",
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

    public function ourPricingSection()
    {
        $ourPricing = FeesOurPricing::get();
        return view('fees-section.ourpricing', compact('ourPricing'));
    }

    public function saveOurPricingSection(Request $request)
    {
     
            $validated = $request->validate([
                'title' => 'required|string|min:3|max:255',
                'button_content' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:10',
                'sub_title' => 'required|array|min:1',
                'sub_description' => 'required|array|min:1',
                'price' => 'required|array|min:1',
            ], [
                'title.required' => 'The title field is required.',
                'title.min' => 'The title must be at least 3 characters.',
                'title.max' => 'The title must not exceed 255 characters.',
                'description.required' => 'The description field is required.',
                'description.min' => 'The description must be at least 10 characters.',
                'sub_title.required' => 'The sub-title field is required.',
                'sub_description.required' => 'The sub-description field is required.',
                'price.required' => 'The price field is required.',
            ]);
            
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

                // Create the product for each section
                $product = $this->stripe->products->create([
                    'name' => $subTitle, // You can set the product name based on the sub_title or other relevant info
                    'description' => is_array($subDescriptions) ? implode(',', $subDescriptions) : $subDescriptions,
                    'metadata' => [
                        'custom_key' => 'custom_value', // Optionally add metadata
                    ],
                ]);

                // Initialize an array to store multiple price IDs for the current entry
                $priceIds = [];

                // Loop through each price and create a Stripe price
                foreach ($prices as $price) {
                    $stripePrice = $this->stripe->prices->create([
                        'currency' => env('CURRENCY'),  // Currency based on your environment
                        'unit_amount' => $price * 100,   // Convert price to cents
                        'product' => $product->id,       // Use the newly created product ID
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
            $autismSection->button_content = $request->button_content;
            $autismSection->description = $request->description;
            $autismSection->status = $request->status ?? "off";
            $autismSection->pointers = json_encode($pointers);
            $autismSection->page = "Fees";
            $autismSection->url = "fee";
            // Save the record
            $autismSection->save();

            // Success redirect
            return redirect()->route('our-pricing-section')->with('success', 'Pricing section saved successfully.');
        
    }
}
