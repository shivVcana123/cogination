<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
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

    public function saveAdhdBenefits(Request $request)
    {
        // Validate the request data
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'description_1' => 'nullable|string',
                'sub_title.*' => 'nullable|string|max:255',
                'sub_description.*' => 'nullable|string|max:255',
                'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'The title is required.',
                'title.string' => 'The title must be a valid string.',
                'title.max' => 'The title may not exceed 255 characters.',
                'subtitle.required' => 'The subtitle is required.',
                'subtitle.string' => 'The subtitle must be a valid string.',
                'subtitle.max' => 'The subtitle may not exceed 255 characters.',
                'description_1.required' => 'The description is required.',
                'description_1.string' => 'The description must be a valid string.',
                'sub_title.required' => 'At least one sub-title is required.',
                'sub_title.array' => 'The sub-title field must be an array.',
                'sub_title.*.required' => 'Each sub-title is required.',
                'sub_title.*.string' => 'Each sub-title must be a valid string.',
                'sub_title.*.max' => 'Each sub-title may not exceed 255 characters.',
                'sub_description.required' => 'At least one sub-description is required.',
                'sub_description.array' => 'The sub-description field must be an array.',
                'sub_description.*.required' => 'Each sub-description is required.',
                'sub_description.*.string' => 'Each sub-description must be a valid string.',
                'sub_description.*.max' => 'Each sub-description may not exceed 500 characters.',
                'image.image' => 'The uploaded file must be an image.',
                'image.max' => 'The image may not exceed 2MB in size.',
            ]
        );

        // Initialize pointers array
        $pointers = [];

        // Fetch existing record if updating
        // Fetch existing record if updating
        $adhdBenefit = $request->id ? AdhdBenefit::findOrFail($request->id) : null;
        $existingPointers = $adhdBenefit && $adhdBenefit->pointers
            ? json_decode($adhdBenefit->pointers, true)
            : [];


        // Handle multiple pointers if any
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
                $subImagePath = null;

                // Check if image exists for this pointer
                if (isset($request->file('image')[$index]) && $request->file('image')[$index]->isValid()) {
                    // Delete old image if it exists
                    if (isset($existingPointers[$index]['sub_image']) && \Storage::exists($existingPointers[$index]['sub_image'])) {
                        \Storage::delete($existingPointers[$index]['sub_image']);
                    }

                    // Store the new image in the 'adhd' folder
                    $imageName = time() . '_' . $request->file('image')[$index]->getClientOriginalName();
                    $subImagePath = $request->file('image')[$index]->storeAs('adhd', $imageName, 'public');
                    $subImagePath = 'storage/' . $subImagePath; // Ensure proper path format
                } else {
                    // Retain existing image if no new upload
                    $subImagePath = $existingPointers[$index]['sub_image'] ?? null;
                }

                // Append pointer data
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                    'sub_image' => $subImagePath,
                ];
            }
        }


        // Save or update the record
        if ($adhdBenefit) {
            // Update existing record
            $adhdBenefit->title = $validated['title'];
            $adhdBenefit->subtitle = $validated['subtitle'];
            $adhdBenefit->description_1 = $validated['description_1'];
            $adhdBenefit->pointers = json_encode($pointers);
            $adhdBenefit->save();
            $message = 'Our Services details updated successfully.';
        } else {
            // Create a new record
            $adhdBenefit = new AdhdBenefit();
            $adhdBenefit->title = $validated['title'];
            $adhdBenefit->subtitle = $validated['subtitle'];
            $adhdBenefit->description_1 = $validated['description_1'];
            $adhdBenefit->pointers = json_encode($pointers);
            $adhdBenefit->save();
            $message = 'Our Services details saved successfully.';
        }

        // Redirect with a success message
        return redirect()->route('adhd-benefits')->with('success', $message);
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

    public function saveAdhdSection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string',
            'first_title' => 'required|string|max:255',
            'first_subtitle' => 'required|string|max:255',
            'first_description' => 'required|string',
            'first_button_content' => 'nullable|string|max:255',
            'first_button_link' => 'nullable|string|max:255',
            'second_title' => 'required|string|max:255',
            'second_subtitle' => 'required|string|max:255',
            'second_description' => 'required|string',
            'second_sub_title' => 'array',
            'second_sub_title.*' => 'nullable|string|max:255',
            'second_sub_description' => 'array',
            'second_sub_description.*' => 'nullable|string',
            'first_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Fetch or create a new section
        $adhdfirstSection = $request->id
            ? AdhdSection::find($request->id)
            : new AdhdSection();

        // Handle pointers
        $pointers = [];
        if ($request->has('second_sub_title')) {
            foreach ($validated['second_sub_title'] as $index => $subTitle) {
                $pointers[] = [
                    'second_sub_title' => $subTitle,
                    'second_sub_description' => $validated['second_sub_description'][$index] ?? null,
                ];
            }
        }

        // Assign data
        $adhdfirstSection->type = $validated['type'];
        $adhdfirstSection->first_title = $validated['first_title'];
        $adhdfirstSection->first_subtitle = $validated['first_subtitle'];
        $adhdfirstSection->first_description = $validated['first_description'];
        $adhdfirstSection->first_button_content = $validated['first_button_content'];
        $adhdfirstSection->first_button_link = $validated['first_button_link'];
        $adhdfirstSection->second_title = $validated['second_title'];
        $adhdfirstSection->second_subtitle = $validated['second_subtitle'];
        $adhdfirstSection->second_description = $validated['second_description'];
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
