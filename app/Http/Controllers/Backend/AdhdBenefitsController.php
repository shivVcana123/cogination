<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\AdhdBenefit;
use App\Models\AdhdChildSection;
use App\Models\AdhdSection;
use Illuminate\Http\Request;

class AdhdBenefitsController extends Controller
{
    public function adhdBenefits()
    {
        $adhdBenefit = AdhdBenefit::all();
        return view('adhd-section.adhdbenefits', compact('adhdBenefit'));
    }

    public function fetchAdhdBenefitSectionByType(Request $request)
    {
        $type = $request->type;

        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $adhdSection = AdhdBenefit::where('type', $type)->get();

        return response()->json(['data' => $adhdSection]);
    }

    public function saveAdhdBenefits(TitleRequest $request)
    {
        // dd($request->all());
        try {
            // Fetch existing record or create a new one
            $adhdBenefit = $request->id
                ? AdhdBenefit::find($request->id)
                : new AdhdBenefit();

            // Initialize pointers array
            $pointers = [];

            // Process pointers if present
            if (!empty($request->sub_title)) {
                foreach ($request->sub_title as $index => $subTitle) {
                    $subImagePath = null;

                    // Handle image upload if provided
                    if (isset($request->file('image')[$index]) && $request->file('image')[$index]->isValid()) {
                        $imageName = time() . '_' . $request->file('image')[$index]->getClientOriginalName();
                        $subImagePath = $request->file('image')[$index]->storeAs('adhd', $imageName, 'public');
                        $subImagePath = 'storage/' . $subImagePath;
                    } elseif (isset($adhdBenefit->pointers)) {
                        $existingPointers = json_decode($adhdBenefit->pointers, true);
                        $subImagePath = $existingPointers[$index]['sub_image'] ?? null;
                    }

                    // Append pointer data
                    $pointers[] = [
                        'sub_title' => $subTitle,
                        'sub_description' => $request->sub_description[$index] ?? null,
                        'sub_image' => $subImagePath,
                    ];
                }
            }

            // dd($pointers);

            // Populate and save the model
            $adhdBenefit->type = $request->type;
            $adhdBenefit->title = $request->title;
            $adhdBenefit->subtitle = $request->subtitle;
            $adhdBenefit->description_1 = $request->description_1;
            $adhdBenefit->status = $request->status ?? "off";
            $adhdBenefit->pointers = json_encode($pointers);
            $adhdBenefit->save();

            // Success message
            $message = $request->id
                ? 'adhdBenefit details updated successfully.'
                : 'adhdBenefit details saved successfully.';

            // Redirect with success message
            return redirect()->route('adhd-benefits')->with('success', $message);
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function adhdSection()
    {
        $adhdSection = AdhdSection::get();
        return view('adhd-section.adhdsection', compact('adhdSection'));
    }
    public function fetchAdhdSectionByType(Request $request)
    {
        $type = $request->type;

        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $adhdSection = AdhdSection::where('type', $type)->get();

        return response()->json(['data' => $adhdSection]);
    }



    public function saveAdhdSection(TitleRequest $request)
    {
        // dd($request->all());
        // Fetch or create a new section
        $adhdfirstSection = $request->id
            ? AdhdSection::find($request->id)
            : new AdhdSection();

        // Handle pointers
        $pointers = [];
        if ($request->has('second_sub_title')) {
            foreach ($request->second_sub_title as $index => $subTitle) {
                $pointers[] = [
                    'second_sub_title' => $subTitle,
                    'second_sub_description' => $request->second_sub_description[$index] ?? null,
                ];
            }
        }

        // Assign data
        $adhdfirstSection->type = $request->type;
        $adhdfirstSection->first_title = $request->first_title;
        $adhdfirstSection->first_subtitle = $request->first_subtitle;
        $adhdfirstSection->first_description = $request->first_description;
        $adhdfirstSection->first_button_content = $request->first_button_content;
        $adhdfirstSection->first_button_link = $request->first_button_link;
        $adhdfirstSection->second_title = $request->second_title;
        $adhdfirstSection->second_subtitle = $request->second_subtitle;
        $adhdfirstSection->second_description = $request->second_description;
        $adhdfirstSection->status = $request->status ?? "off";
        $adhdfirstSection->pointers = json_encode($pointers);

        // Handle first image upload
        if ($request->hasFile('first_image') && $request->file('first_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('first_image')->getClientOriginalName();
            $imagePath = $request->file('first_image')->storeAs('adhd', $imageName, 'public');
            $adhdfirstSection->first_image = 'storage/' . $imagePath;
        }

        // Handle second image upload
        if ($request->hasFile('second_image') && $request->file('second_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('second_image')->getClientOriginalName();
            $imagePath = $request->file('second_image')->storeAs('adhd', $imageName, 'public');
            $adhdfirstSection->second_image = 'storage/' . $imagePath;
        }

        // Save the record
        if (!$adhdfirstSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }

        return redirect()->route('adhd-section')->with('success', 'Adhd details saved successfully.');
    }
}
