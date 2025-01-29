<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\AdhdBenefit;
use App\Models\AdhdChildSection;
use App\Models\AdhdSecondSection;
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
       
        $validated = $request->validate([
            'type' => 'required',
            'title' => 'required',
            'subtitle' => 'nullable',
            'description_1' => 'required',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'nullable', 
            'image' => 'sometimes|array',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'type.required' => 'The type field is required.',
            'title.required' => 'The title field is required.',
            'description_1.required' => 'The description field is required.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'image.*.image' => 'Each uploaded file must be an image.',
            'image.*.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
        ]);
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

    public function saveAdhdSection(Request $request)
    {
   
        $validated = $request->validate([
            'type' => 'required',
            'first_title' => 'required',
            'first_subtitle' => 'nullable',
            'first_button_content' => 'nullable',
            'first_button_link' => 'nullable|required_with:first_button_content',
            'first_description' => 'required',
            'first_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Ensure correct field name & max size 2MB
        ], [
            'type.required' => 'The type field is required.',
            'first_title.required' => 'The title field is required.',
            'first_button_link.required_with' => 'The button link is required when button content is provided.',
            'first_button_link.url' => 'The button link must be a valid URL.',
            'first_description.required' => 'The description field is required.',
            'first_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'first_image.max' => 'The image must not exceed 2MB in size.',
        ]);


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
        // $adhdfirstSection->second_title = $request->second_title;
        // $adhdfirstSection->second_subtitle = $request->second_subtitle;
        // $adhdfirstSection->second_description = $request->second_description;
        // $adhdfirstSection->status = $request->status ?? "off";
        // $adhdfirstSection->pointers = json_encode($pointers);

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

    public function adhdSecondSection ()
    {
        $adhdSection = AdhdSecondSection::get();
        return view('adhd-section.adhdsecond', compact('adhdSection'));
    }
    
    public function saveAdhdSecond(Request $request)
    {
 
            // dd($request->all());
        $validated = $request->validate([
            'type' => 'required',
            'second_title' => 'required',
            'second_subtitle' => 'nullable',
            'second_description' => 'required',
            'heading' => 'nullable',
            'second_sub_title' => 'nullable|array',
            'second_sub_title.*' => 'required_with:second_sub_description.*',
            'second_sub_description' => 'nullable|array',
            'second_sub_description.*' => 'required_with:second_sub_title.*',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'type.required' => 'The type field is required.',
            'second_title.required' => 'The second title field is required.',
            'second_description.required' => 'The description field is required.',
            'second_sub_title.*.required_with' => 'Each subtitle must be provided if a sub-description is given.',
            'second_sub_description.*.required_with' => 'Each sub-description must be provided if a subtitle is given.',
            'second_image.image' => 'The second image must be an image file.',
            'second_image.mimes' => 'The second image must be a file of type: jpeg, png, jpg, gif, webp.',
        ]);    

      
            // Fetch or create a new section
            $adhdSecondSection = $request->id
                ? AdhdSecondSection::find($request->id)
                : new AdhdSecondSection();
    
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
            $adhdSecondSection->type = $validated['type'];
            $adhdSecondSection->second_title = $validated['second_title'];
            $adhdSecondSection->second_subtitle = $validated['second_subtitle'] ?? null;
            $adhdSecondSection->second_description = $validated['second_description'] ?? null;
            $adhdSecondSection->heading = $validated['heading'] ?? null;
            $adhdSecondSection->status = $request->status ?? "off";
            $adhdSecondSection->pointers = json_encode($pointers);
    
            // Handle second image upload
            if ($request->hasFile('second_image') && $request->file('second_image')->isValid()) {
                $imageName = time() . '_' . uniqid() . '_' . $request->file('second_image')->getClientOriginalName();
                $imagePath = $request->file('second_image')->storeAs('adhd', $imageName, 'public');
                $adhdSecondSection->second_image = 'storage/' . $imagePath;
            }
    
            // Save the record
            $adhdSecondSection->save();
    
            return redirect()->route('adhd-second-section')->with('success', 'Adhd details saved successfully.');
    
    }
    

    public function fetchAdhdSecondSectionByType(Request $request)
    {
        $type = $request->type;

        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $adhdSection = AdhdSecondSection::where('type', $type)->get();

        return response()->json(['data' => $adhdSection]);
    }

}
