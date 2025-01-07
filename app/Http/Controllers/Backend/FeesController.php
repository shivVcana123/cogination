<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FeesOurPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeesController extends Controller
{

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

    public function saveOurPricingSection(Request $request)
    {
        // dd($request->all());
    
        try {
            // Validate request data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'sub_title' => 'array',
                'sub_title.*' => 'nullable|string|max:255',
                'sub_description' => 'array', // Ensure sub_description is an array
                'sub_description.*' => 'array', // Each element of sub_description must be an array
                'sub_description.*.*' => 'nullable|string', // Each item inside the sub_description array must be a string or null
            ]);
            

            
            // Fetch or create a new section
            $autismSection = $request->id
                ? FeesOurPricing::find($request->id)
                : new FeesOurPricing();
    
            // Handle pointers (sub_title, sub_description, child_description)
            $pointers = [];
    
            // Loop through sub_titles
            foreach ($request->input('sub_title', []) as $index => $subTitle) {
                // Collect all sub_descriptions for the current index
                $subDescriptions = $request->input("sub_description.{$index}", []);
    
                // Ensure $subDescriptions is an array and join them
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => is_array($subDescriptions) 
                        ? implode(',', $subDescriptions) 
                        : $subDescriptions,
                ];
            }
    
            // Assign validated data to the model
            $autismSection->title = $validated['title'];
            $autismSection->description = $validated['description'];
            $autismSection->status = $request->status ?? "off";
            $autismSection->pointers = json_encode($pointers);
    
            // Save the record
            $autismSection->save();
    
            // Success redirect
            return redirect()->route('our-pricing-section')->with('success', 'Pricing section saved successfully.');
    
        } catch (\Exception $e) {
            dd($e);
            // Handle any exceptions (validation, database, etc.)
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    
    
}
