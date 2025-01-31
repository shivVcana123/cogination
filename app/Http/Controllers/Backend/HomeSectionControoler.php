<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\HomeBringingHealthcare;
use App\Models\BringingHealthcare;
use App\Models\HomeAboutUsData;
use App\Models\HomeAppointment;
use App\Models\HomeChooseUs;
use App\Models\HomeFaq;
use App\Models\HomeOurService;
use App\Traits\UploadImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionControoler extends Controller
{


    public function homeAbout()
    {
        // Fetch all records to display or pass to the view
        $chooseusData = HomeAboutUsData::first();
        return view('home-section.homeAbout', compact('chooseusData'));
    }


    public function saveHomeAbout(Request $request)
    {
        // Validate request data
        $request->validate(
            [
                'title' => 'required',
                // 'subtitle' => 'required', 
                'description' => 'required',
                'button_content' => 'nullable',
                'button_link' => 'nullable|required_with:button_content',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp', // Validate image type and size
            ],
            [
                'title.required' => 'The title field is required.',
                // 'subtitle.required' => 'The subtitle field is required.',
                'description.required' => 'The description field is required.',
                'button_link.required_with' => 'The button link is required when button text is present.',
                'image.image' => 'The uploaded file must be an image.',
                'image.mimes' => 'The image must be in jpeg, png, jpg, gif, webp, or svg format.',
            ]
        );

        // Handle saving or updating HomeAboutUsData record
        $about = $request->id ? HomeAboutUsData::find($request->id) : new HomeAboutUsData();
        $about->title = $request->title;
        $about->subtitle = $request->subtitle;
        $about->description = $request->description;
        $about->button_content = $request->button_content;
        $about->button_link = $request->button_link;
        $about->status = $request->status ?? "off";

        // Image handling logic
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if exists
            if ($about->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $about->image));
            }

            // Get and clean up image file name
            $originalName = $request->file('image')->getClientOriginalName();
            $cleanedName = str_replace(' ', '_', $originalName); // Replace spaces with underscores
            $imageName = uniqid() . '_' . $cleanedName;

            // Store the new image
            $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
            $about->image = 'storage/' . $imagePath;
        }

        // Save the record
        $about->save();

        return redirect()->route('homeAbout')->with('message', 'Data saved successfully.');
    }


    public function appointment()
    {
        $appointment = HomeAppointment::latest()->first();
        return view('home-section.appointment', compact('appointment'));
    }
  
    public function saveappointment(Request $request)
    {

        // Validate request data
        $request->validate(
            [
                'title' => 'required',
                'subtitle' => 'required',
                'button_content' => 'nullable',
                'button_link' => 'nullable|required_with:button_content',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ],
            [
                'title.required' => 'The title field is required.',
                'subtitle.required' => 'The description field is required.',
                'button_link.required_with' => 'The button link is required when button content is provided.',
                'image.image' => 'The uploaded file must be an image.',
                'image.mimes' => 'The image must be in jpeg, png, jpg, gif, webp, or svg format.',
            ]
        );

        // Fetch or create a new record
        $healthcare = $request->id ? HomeAppointment::find($request->id) : new HomeAppointment();
        if (!$healthcare) {
            return redirect()->route('whyhealthcare')->withErrors('Record not found.');
        }

        // Assign values from request
        $healthcare->title = $request->title;
        $healthcare->subtitle = $request->subtitle ?? null;
        $healthcare->button_content = $request->button_content ?? null;
        $healthcare->button_link = $request->button_link ?? null;
        $healthcare->status = $request->status ?? "off";

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $directory = 'home';

            // Delete the old image if it exists
            if ($healthcare->image) {
                $oldImage = str_replace('storage/', '', $healthcare->image);
                Storage::disk('public')->delete($oldImage);
            }

            // Upload the new image
            $uploadedImage = $request->file('image');
            $imageName = uniqid() . '_' . str_replace(' ', '_', $uploadedImage->getClientOriginalName());
            $imagePath = $uploadedImage->storeAs($directory, $imageName, 'public');
            $healthcare->image = 'storage/' . $imagePath;
        }

        // Save the record
        $healthcare->save();

        return redirect()->route('appointment')->with('message', 'Data saved successfully.');
    }

    public function whychooseus()
    {
        // Fetch all records to display or pass to the view
        $chooseusData = HomeChooseUs::all();
        return view('home-section.whychooseus', compact('chooseusData'));
    }

    public function savewhychooseus(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'description_1' => 'required',
            'sub_title' => 'nullable|array',
            'sub_description' => 'nullable|array',
            'sub_title.*' => 'required_with:sub_description.*',
            'sub_description.*' => 'required_with:sub_title.*',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ], [
            'title.required' => 'The title field is required.',
            'description_1.required' => 'The description field is required.',
            'sub_title.*.required_with' => 'Each subtitle must have a corresponding sub-description.',
            'sub_description.*.required_with' => 'Each sub-description must have a corresponding subtitle.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, webp.',
        ]);



        // Prepare pointers from sub_title and sub_description
        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
                ];
            }
        }

        // Find existing record or create new one
        $chooseus = $request->id ? HomeChooseUs::find($request->id) : new HomeChooseUs();

        // Assign validated fields
        $chooseus->title = $request->title;
        $chooseus->subtitle = $request->subtitle ?? null;
        $chooseus->description_1 = $request->description_1 ?? null;
        $chooseus->status = $request->status ?? "off";
        $chooseus->pointers = json_encode($pointers);

        // Handle image upload if provided
        if ($request->hasFile('second_image') && $request->file('second_image')->isValid()) {
            // Delete old image if it exists
            if ($chooseus->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $chooseus->image));
            }

            // Save new image with a unique name
            $originalName = $request->file('second_image')->getClientOriginalName();
            $cleanedName = str_replace(' ', '_', $originalName);
            $imageName = uniqid() . '_' . $cleanedName;
            $imagePath = $request->file('second_image')->storeAs('home', $imageName, 'public');
            $chooseus->image = 'storage/' . $imagePath;
        }

        // Save record
        $chooseus->save();

        return redirect()->route('whychooseus')->with('message', 'Data saved successfully.');
    }



    public function bringinghealthcare()
    {
        $healthcare = HomeBringingHealthcare::all();
        return view('home-section.bringinghealthcare', compact('healthcare'));
    }

    public function savebringinghealthcare(Request $request)
    {
        // dd( $request->all());
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', // No need for nullable since 'image' is required

        ], [
            'title.required' => 'The title field is required.',
            'image.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, webp.',
        ]);
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
        $healthcare->status = $request->status ?? "off";

        // Handle image upload
   
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($healthcare->image && \Storage::exists(str_replace('storage/', '', $healthcare->image))) {
                \Storage::delete(str_replace('storage/', '', $healthcare->image));
            }

            // Store the new image with the original file name
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
            $healthcare->image = 'storage/' . $imagePath;
        }

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
                'title' => 'required',
                'subtitle' => 'nullable',
                'question' => 'required|array',
                'question.*' => 'required',
                'answer' => 'required|array',
                'answer.*' => 'required',
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
        $saveFaqs->status = $request->status ?? "off";
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

    public function saveOurServices(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description_1' => 'required|string',
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // No need for nullable since 'image' is required
            'sub_title' => 'required|array',
            'sub_title.*' => 'required|string',
            'sub_description' => 'required|array',
            'sub_description.*' => 'required|string', // No need for required_with since sub_title.* is required
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'subtitle.string' => 'The subtitle must be a valid string.',
            'description_1.required' => 'The description field is required.',
            'sub_title.*.required' => 'Each subtitle is required.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'image.required' => 'At least one image is required.',
            'image.*.image' => 'Each image must be a valid image file.',
            'image.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.*.max' => 'Each image size must not exceed 2MB.',
        ]);



        // Initialize pointers array
        $pointers = [];

        // Check if we are updating an existing record
        $ourservice = $request->id ? HomeOurService::find($request->id) : new HomeOurService();

        // Decode the existing pointers if updating
        $existingPointers = $ourservice->id ? json_decode($ourservice->pointers, true) : [];

        // Handle multiple pointers if any
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
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
                    'sub_description' => $request->sub_description[$index] ?? null,
                    'sub_image' => $subImagePath ? 'storage/' . $subImagePath : ($existingPointers[$index]['sub_image'] ?? null),
                ];
            }
        }

        // Assign the validated data to the ourservice model
        $ourservice->title = $request->title;
        $ourservice->subtitle = $request->subtitle;
        $ourservice->description_1 = $request->description_1;
        $ourservice->status = $request->status ?? "off";
        $ourservice->pointers = json_encode($pointers);  // Store updated pointers data

        // Save the model (create or update)
        $ourservice->save();

        $message = $ourservice->wasRecentlyCreated ? 'Our Services created successfully.' : 'Our Services updated successfully.';

        // Redirect with a success message
        return redirect()->route('our-services')->with('success', $message);
    }
}
