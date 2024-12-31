<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\HomeBringingHealthcare;
use App\Models\HomeAppointment;
use App\Models\HomeChooseUs;
use App\Models\HomeFaq;
use App\Models\HomeOurService;
use App\Traits\UploadImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionControoler extends Controller
{
    use UploadImages;
    /**
     * Display a listing of the resource.
     */

     public function appointment()
     {
         $appointment = HomeAppointment::latest()->first();
         return view('home-section.appointment',compact('appointment'));
     }
     public function saveappointment(TitleRequest $request)
     {
         $healthcare = $request->id ? HomeAppointment::find($request->id) : new HomeAppointment();
         if (!$healthcare) {
             return redirect()->route('whyhealthcare')->withErrors('Record not found.');
         }
         $healthcare->title = $request->title;
         $healthcare->subtitle = $request->subtitle ?? null;
         $healthcare->button_content = $request->button_content ?? null;
         $healthcare->button_link = $request->button_link ?? null;
         if ($request->hasFile('image') && $request->file('image')->isValid()) {
             $directory = 'home';
             $oldImage = str_replace('storage/', '', $healthcare->image);
             $healthcare->image = 'storage/' . $this->uploadImages($request->file('image'), $directory, $oldImage);
         }
         $healthcare->save();
         return redirect()->route('appointment')->with('message', 'Data saved successfully.');
     }
    public function whychooseus()
    {
        // Fetch all records to display or pass to the view
        $chooseusData = HomeChooseUs::all();
        return view('home-section.whychooseus', compact('chooseusData'));
    }
    
    public function savewhychooseus(TitleRequest $request)
    {
        // Validate incoming request
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
        $chooseus->title = $request->title;
        $chooseus->subtitle = $request->subtitle ?? null;
        $chooseus->description_1 = $request->description_1 ?? null;
        $chooseus->pointers = json_encode($pointers);
    
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $directory = 'home';
            $oldImage = str_replace('storage/', '', $chooseus->image);
            $chooseus->image = 'storage/' . $this->uploadImages($request->file('image'), $directory, $oldImage);
        }
        // if ($request->hasFile('image') && $request->file('image')->isValid()) {
        //     if ($chooseus->image) {
        //         Storage::disk('public')->delete(str_replace('storage/', '', $chooseus->image));
        //     }
        //     $originalName = $request->file('image')->getClientOriginalName();
        //     $cleanedName = str_replace(' ', '_', $originalName); // Replace spaces with underscores
        //     $imageName = uniqid() . '_' . $cleanedName;
        //     $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
        //     $chooseus->image = 'storage/' . $imagePath;
        // }
    
        // Save the record
        $chooseus->save();
    
        return redirect()->route('whychooseus')->with('message', 'Data saved successfully.');
    }
    
    

    public function bringinghealthcare()
    {
        $healthcare = HomeBringingHealthcare::all();
        return view('home-section.bringinghealthcare',compact('healthcare'));
    }

    public function savebringinghealthcare(TitleRequest $request)
    {
        // dd( $request->all());
        // Check if an ID is passed for update or create a new record
        $healthcare = $request->id ? HomeBringingHealthcare::find($request->id) : new HomeBringingHealthcare();
    
        if (!$healthcare) {
            return redirect()->route('whyhealthcare')->withErrors('Record not found.');
        }
    
        // Assign validated fields
        $healthcare->title = $request->title;
        $healthcare->subtitle = $request->subtitle ?? null;
        $healthcare->button_content1 = $request->button_content1 ?? null;
        $healthcare->button_link1 = $request->button_link1 ?? null;
        $healthcare->button_content2 = $request->button_content2 ?? null;
        $healthcare->button_link2 = $request->button_link2 ?? null;
    
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $directory = 'home';
            $oldImage = str_replace('storage/', '', $healthcare->image);
            $healthcare->image = 'storage/' . $this->uploadImages($request->file('image'), $directory, $oldImage);
        }
        // if ($request->hasFile('image')) {
        //     // Delete the old image if it exists
        //     if ($healthcare->image && \Storage::exists(str_replace('storage/', '', $healthcare->image))) {
        //         \Storage::delete(str_replace('storage/', '', $healthcare->image));
        //     }
    
        //     // Store the new image with the original file name
        //     $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        //     $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
        //     $healthcare->image = 'storage/' . $imagePath;
        // }
    
        // Save the record
        $healthcare->save();
    
        return redirect()->route('bringinghealthcare')->with('message', 'Data saved successfully.');
    }


    public function faqs()
    {
        $saveFaqs = HomeFaq::all(); // Retrieve all FAQs
        return view('home-section.faqs', compact('saveFaqs'));
    }
    

    public function saveFaqs(Request $request)
    {
        // dd($request->all());
        // Validate incoming request
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'question' => 'required|array',
                'question.*' => 'required|string|max:255',
                'answer' => 'required|array',
                'answer.*' => 'required|string|max:500',
            ],
            [
                'title.required' => 'The title is required.',
                'title.string' => 'The title must be a valid string.',
                'title.max' => 'The title may not exceed 255 characters.',
                'subtitle.required' => 'The subtitle is required.',
                'subtitle.string' => 'The subtitle must be a valid string.',
                'subtitle.max' => 'The subtitle may not exceed 255 characters.',
                'question.required' => 'At least one sub-title is required.',
                'question.array' => 'The sub-title field must be an array.',
                'question.*.required' => 'Each sub-title is required.',
                'question.*.string' => 'Each sub-title must be a valid string.',
                'question.*.max' => 'Each sub-title may not exceed 255 characters.',
                'answer.required' => 'At least one sub-description is required.',
                'answer.array' => 'The sub-description field must be an array.',
                'answer.*.required' => 'Each sub-description is required.',
                'answer.*.string' => 'Each sub-description must be a valid string.',
                'answer.*.max' => 'Each sub-description may not exceed 500 characters.',
            ]
        );
        
    
        $pointers = [];
        if (!empty($request->question)) {
            foreach ($request->question as $index => $subTitle) {
                $pointers[] = [
                    'question' => $subTitle,
                    'answer' => $request->answer[$index] ?? null,
                ];
            }
        }
    
        // Check if an ID is passed for update or create a new record
        $saveFaqs = $request->id ? HomeFaq::find($request->id) : new HomeFaq();
    
        if (!$saveFaqs) {
            return redirect()->route('save-faq')->withErrors('Record not found.');
        }
    
        // Assign validated fields
        $saveFaqs->title = $validated['title'];
        $saveFaqs->subtitle = $validated['subtitle'] ?? null;
        $saveFaqs->pointers = json_encode($pointers);
    
        // Save the record
        $saveFaqs->save();
    
        return redirect()->route('faqs')->with('message', 'Data saved successfully.');
    }

    public function ourservices()
    {
        // Fetch all records to display or pass to the view
        $chooseusData = HomeOurService::all();
        return view('home-section.ourservices', compact('chooseusData'));
    }
    
    // public function saveourservices(Request $request)
    // {
    //     dd($request->all());
    //     // Validate incoming request
    //     $validated = $request->validate(
    //         [
    //             'title' => 'required|string|max:255',
    //             'subtitle' => 'required|string|max:255',
    //             'description_1' => 'required|string',
    //             'sub_title' => 'required|array',
    //             'sub_title.*' => 'required|string|max:255',
    //             'sub_description' => 'required|array',
    //             'sub_description.*' => 'required|string|max:500',
    //             'image' => 'nullable|image|max:2048', // Validate image type and size
    //         ],
    //         [
    //             'title.required' => 'The title is required.',
    //             'title.string' => 'The title must be a valid string.',
    //             'title.max' => 'The title may not exceed 255 characters.',
    //             'subtitle.required' => 'The subtitle is required.',
    //             'subtitle.string' => 'The subtitle must be a valid string.',
    //             'subtitle.max' => 'The subtitle may not exceed 255 characters.',
    //             'description_1.required' => 'The description is required.',
    //             'description_1.string' => 'The description must be a valid string.',
    //             'sub_title.required' => 'At least one sub-title is required.',
    //             'sub_title.array' => 'The sub-title field must be an array.',
    //             'sub_title.*.required' => 'Each sub-title is required.',
    //             'sub_title.*.string' => 'Each sub-title must be a valid string.',
    //             'sub_title.*.max' => 'Each sub-title may not exceed 255 characters.',
    //             'sub_description.required' => 'At least one sub-description is required.',
    //             'sub_description.array' => 'The sub-description field must be an array.',
    //             'sub_description.*.required' => 'Each sub-description is required.',
    //             'sub_description.*.string' => 'Each sub-description must be a valid string.',
    //             'sub_description.*.max' => 'Each sub-description may not exceed 500 characters.',
    //             'image.image' => 'The uploaded file must be an image.',
    //             'image.max' => 'The image may not exceed 2MB in size.',
    //         ]
    //     );
        
    
    //     // Combine `sub_title`, `sub_description`, and `sub_images` into JSON
    // $pointers = [];
    // foreach ($request->sub_title as $index => $subTitle) {
    //     $subImagePath = null;

    //     if ($request->hasFile("sub_images.$index")) {
    //         $subImagePath = $request->file("sub_images.$index")->store('public/pointers');
    //         $subImagePath = str_replace('public/', 'storage/', $subImagePath);
    //     }

    //     $pointers[] = [
    //         'sub_title' => $subTitle,
    //         'sub_description' => $request->sub_description[$index] ?? null,
    //         'sub_image' => $subImagePath,
    //     ];
    // }

    // // Check if an ID is passed for update or create a new record
    // $ourservice = $request->id ? HomeOurService::find($request->id) : new HomeOurService();

    // if (!$ourservice) {
    //     return redirect()->route('our-services')->withErrors('Record not found.');
    // }

    // // Assign validated fields
    // $ourservice->title = $validated['title'];
    // $ourservice->subtitle = $validated['subtitle'];
    // $ourservice->description_1 = $validated['description_1'];
    // $ourservice->pointers = json_encode($pointers);

    // // Handle main image upload
    // if ($request->hasFile('image')) {
    //     if ($ourservice->image && \Storage::exists($ourservice->image)) {
    //         \Storage::delete($ourservice->image);
    //     }

    //     $imagePath = $request->file('image')->store('public/images');
    //     $ourservice->image = str_replace('public/', 'storage/', $imagePath);
    // }

    // $ourservice->save();

    // return redirect()->route('our-services')->with('success', 'Our Services details saved successfully.');
    // }

    // public function saveourservices(Request $request)
    // {
    //     // Validate the request data
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'subtitle' => 'nullable|string|max:255',
    //         'description_1' => 'nullable|string',
    //         'sub_title.*' => 'nullable|string|max:255',
    //         'sub_description.*' => 'nullable|string|max:255',
    //         'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
    //     ], [
    //         'title.required' => 'The title is required.',
    //         'title.string' => 'The title must be a valid string.',
    //         'title.max' => 'The title may not exceed 255 characters.',
    //         'subtitle.string' => 'The subtitle must be a valid string.',
    //         'subtitle.max' => 'The subtitle may not exceed 255 characters.',
    //         'description_1.string' => 'The description must be a valid string.',
    //         'sub_title.*.string' => 'Each sub-title must be a valid string.',
    //         'sub_title.*.max' => 'Each sub-title may not exceed 255 characters.',
    //         'sub_description.*.string' => 'Each sub-description must be a valid string.',
    //         'sub_description.*.max' => 'Each sub-description may not exceed 255 characters.',
    //         'image.*.image' => 'The uploaded file must be an image.',
    //         'image.*.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg.',
    //         'image.*.max' => 'The image may not exceed 2MB in size.',
    //     ]);
    
    //     // Initialize pointers array
    //     $pointers = [];
    
    //     // Handle multiple pointers if any
    //     if (!empty($validated['sub_title'])) {
    //         foreach ($validated['sub_title'] as $index => $subTitle) {
    //             // Upload image if provided for each pointer
    //             $subImagePath = null;
    //             if ($request->hasFile("image.$index") && $request->file("image.$index")->isValid()) {
    //                 // Delete the old image if it exists (optional, depends on existing data structure)
    //                 if (isset($ourservice->pointers[$index]['sub_image'])) {
    //                     \Storage::disk('public')->delete(str_replace('storage/', '', $ourservice->pointers[$index]['sub_image']));
    //                 }
        
    //                 // Get the original file name and replace spaces with underscores
    //                 $imageName = time() . '_' . str_replace(' ', '_', $request->file("image.$index")->getClientOriginalName());
        
    //                 // Store the new image with the updated file name
    //                 $subImagePath = $request->file("image.$index")->storeAs('home', $imageName, 'public');
    //             }
        
    //             // Add pointer data to the pointers array
    //             $pointers[] = [
    //                 'sub_title' => $subTitle,
    //                 'sub_description' => $validated['sub_description'][$index] ?? null,
    //                 'sub_image' => $subImagePath ? 'storage/' . $subImagePath : null,
    //             ];
    //         }
    //     }
        
    
    //     // Check if an ID is provided (update) or not (create new)
    //     if ($request->id) {
    //         // Update the existing record
    //         $ourservice = HomeOurService::findOrFail($request->id);
    //         $ourservice->title = $validated['title'];
    //         $ourservice->subtitle = $validated['subtitle'];
    //         $ourservice->description_1 = $validated['description_1'];
    //         $ourservice->pointers = json_encode($pointers);
    //         $ourservice->save();
    //         $message = 'Our Services details updated successfully.';
    //     } else {
    //         // Create a new record
    //         $ourservice = new HomeOurService();
    //         $ourservice->title = $validated['title'];
    //         $ourservice->subtitle = $validated['subtitle'];
    //         $ourservice->description_1 = $validated['description_1'];
    //         $ourservice->pointers = json_encode($pointers);
    //         $ourservice->save();
    //         $message = 'Our Services details saved successfully.';
    //     }
    
    //     // Redirect with a success message
    //     return redirect()->route('our-services')->with('success', $message);
    // }
    
    
    public function saveOurServices(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description_1' => 'nullable|string',
            'sub_title.*' => 'nullable|string|max:255',
            'sub_description.*' => 'nullable',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ], [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not exceed 255 characters.',
            'subtitle.string' => 'The subtitle must be a valid string.',
            // 'subtitle.max' => 'The subtitle may not exceed 255 characters.',
            'description_1.string' => 'The description must be a valid string.',
            'sub_title.*.string' => 'Each sub-title must be a valid string.',
            'sub_title.*.max' => 'Each sub-title may not exceed 255 characters.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.max' => 'Each sub-description may not exceed 255 characters.',
            'image.*.image' => 'The uploaded file must be an image.',
            'image.*.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg.',
            'image.*.max' => 'The image may not exceed 2MB in size.',
        ]);
    
        // Initialize pointers array
        $pointers = [];
    
        // Check if we are updating an existing record
        $ourservice = $request->id ? HomeOurService::find($request->id) : new HomeOurService();
    
        // Decode the existing pointers if updating
        $existingPointers = $ourservice->id ? json_decode($ourservice->pointers, true) : [];
    
        // Handle multiple pointers if any
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
                // Upload image if provided for each pointer
                $subImagePath = null;
    
                if ($request->hasFile("image.$index") && $request->file("image.$index")->isValid()) {
                    // Delete the old image if it exists (optional, depends on existing data structure)
                    if (isset($existingPointers[$index]['sub_image'])) {
                        \Storage::disk('public')->delete(str_replace('storage/', '', $existingPointers[$index]['sub_image']));
                    }
    
                    // Get the original file name and replace spaces with underscores
                    $imageName = time() . '_' . str_replace(' ', '_', $request->file("image.$index")->getClientOriginalName());
    
                    // Store the new image with the updated file name
                    $subImagePath = $request->file("image.$index")->storeAs('home', $imageName, 'public');
                }
    
                // Add pointer data to the pointers array
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                    'sub_image' => $subImagePath ? 'storage/' . $subImagePath : ($existingPointers[$index]['sub_image'] ?? null),
                ];
            }
        }
    
        // Assign the validated data to the ourservice model
        $ourservice->title = $validated['title'];
        $ourservice->subtitle = $validated['subtitle'];
        $ourservice->description_1 = $validated['description_1'];
        $ourservice->pointers = json_encode($pointers);  // Store updated pointers data
    
        // Save the model (create or update)
        $ourservice->save();
    
        $message = $ourservice->wasRecentlyCreated ? 'Our Services created successfully.' : 'Our Services updated successfully.';
    
        // Redirect with a success message
        return redirect()->route('our-services')->with('success', $message);
    }
    
    



    // public function saveappointment(Request $request)
    // {
    //     // Validate incoming request
    //     $validated = $request->validate(
    //         [
    //             'title' => 'required|string|max:255',
    //             'subtitle' => 'required|string|max:255',
    //             'button_content' => 'required|string|max:255',
    //             'button_link' => 'required|string|max:255',
    //             'image' => 'nullable|image|max:2048', // Validate image type and size
    //         ],
    //         [
    //             'title.required' => 'The title is required.',
    //             'title.string' => 'The title must be a valid string.',
    //             'title.max' => 'The title may not exceed 255 characters.',
    //             'subtitle.required' => 'The subtitle is required.',
    //             'subtitle.string' => 'The subtitle must be a valid string.',
    //             'button_content.required' => 'The button content is required.',
    //             'button_link.required' => 'The button link is required.',
    //             'image.image' => 'The uploaded file must be an image.',
    //             'image.max' => 'The image may not exceed 2MB in size.',
    //         ]
    //     );
        

    
    //     // Check if an ID is passed for update or create a new record
    //     $healthcare = $request->id ? HomeAppointment::find($request->id) : new HomeAppointment();
    
    //     if (!$healthcare) {
    //         return redirect()->route('whyhealthcare')->withErrors('Record not found.');
    //     }
    
    //     // Assign validated fields
    //     $healthcare->title = $validated['title'];
    //     $healthcare->subtitle = $validated['subtitle'] ?? null;
    //     $healthcare->button_content = $validated['button_content'] ?? null;
    //     $healthcare->button_link = $validated['button_link'] ?? null;
    
    //     // Handle image upload
    //     // if ($request->hasFile('image')) {
    //     //     // Delete the old image if it exists
    //     //     if ($healthcare->image && \Storage::exists(str_replace('storage/', '', $healthcare->image))) {
    //     //         \Storage::delete(str_replace('storage/', '', $healthcare->image));
    //     //     }
    
    //     //     // Store the new image with the original file name
    //     //     $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
    //     //     $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');
    //     //     $healthcare->image = 'storage/' . $imagePath;
    //     // }

    //     if ($request->hasFile('image') && $request->file('image')->isValid()) {
    //         if ($healthcare->image) {
    //             Storage::disk('public')->delete(str_replace('storage/', '', $healthcare->image));
    //         }
    //         $originalName = $request->file('image')->getClientOriginalName();
    //         $cleanedName = str_replace(' ', '_', $originalName); // Replace spaces with underscores
    //         $imageName = uniqid() . '_' . $cleanedName;
    //         $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
    //         $healthcare->image = 'storage/' . $imagePath;
    //     }
    
    //     // Save the record
    //     $healthcare->save();
    
    //     return redirect()->route('appointment')->with('message', 'Data saved successfully.');
    // }
}
