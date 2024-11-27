<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeChooseUs;
use Illuminate\Http\Request;

class HomeSectionControoler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function whychooseus()
    {
        // Fetch all records to display or pass to the view
        $chooseusData = HomeChooseUs::all();
        return view('home-section.whychooseus.form', compact('chooseusData'));
    }
    
    public function savewhychooseus(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'description_1' => 'required|string',
                'sub_title' => 'required|array',
                'sub_title.*' => 'required|string|max:255',
                'sub_description' => 'required|array',
                'sub_description.*' => 'required|string|max:500',
                'image' => 'nullable|image|max:2048', // Validate image type and size
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
        
    
        // Combine `sub_title` and `sub_description` into JSON
        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
                ];
            }
        }
    
        // Check if an ID is passed for update or create a new record
        $chooseus = $request->id ? HomeChooseUs::find($request->id) : new HomeChooseUs();
    
        if (!$chooseus) {
            return redirect()->route('whychooseus')->withErrors('Record not found.');
        }
    
        // Assign validated fields
        $chooseus->title = $validated['title'];
        $chooseus->subtitle = $validated['subtitle'] ?? null;
        $chooseus->description_1 = $validated['description_1'] ?? null;
        $chooseus->pointers = json_encode($pointers);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($chooseus->image && \Storage::exists(str_replace('storage/', '', $chooseus->image))) {
                \Storage::delete(str_replace('storage/', '', $chooseus->image));
            }
    
            // Store the new image with the original file name
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');
            $chooseus->image = 'storage/' . $imagePath;
        }
    
        // Save the record
        $chooseus->save();
    
        return redirect()->route('whychooseus')->with('message', 'Data saved successfully.');
    }
    
    

    public function bringinghealthcare()
    {
        return view('home-section.bringinghealthcare.form');
    }
    public function faqs()
    {
        return view('home-section.faqs.form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
