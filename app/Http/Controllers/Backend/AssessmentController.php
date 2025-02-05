<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\Assessment;
use App\Models\AssessmentOurDiagnosticService;
use App\Models\AssessmentUnderstandingCondition;
use App\Models\AssessmentWhyChoose;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function assessmentSection()
    {
        $assessmentSection = Assessment::all();
        return view('assessment-section.assessment', compact('assessmentSection'));
    }

    public function saveAssessmentSection(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|min:3|max:255',
            'button_content' => 'nullable|string|min:3|max:255',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required|string|min:100|max:2000', // Min length set to 100
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048', // Max file size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',

            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.min' => 'The subtitle must be at least 3 characters.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',

            'button_content.string' => 'The button content must be a valid string.',
            'button_content.min' => 'The button content must be at least 3 characters.',
            'button_content.max' => 'The button content must not exceed 255 characters.',

            'button_link.required_with' => 'The button link is required when button content is provided.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',

            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image must not exceed 2MB in size.',
        ]);



        // Fetch or create a new section
        $assessmentSection = $request->id
            ? Assessment::find($request->id)
            : new Assessment();



        // Assign data
        $assessmentSection->title = $request->title;
        $assessmentSection->subtitle = $request->subtitle;
        $assessmentSection->description = $request->description;
        $assessmentSection->button_content = $request->button_content;
        $assessmentSection->button_link = $request->button_link;
        $assessmentSection->status = $request->status ?? "off";

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('assessment', $imageName, 'public');
            $assessmentSection->image = 'storage/' . $imagePath;
        }

        $assessmentSection->save();

        return redirect()->route('assessment-section')->with('success', 'Adhd details saved successfully.');
    }

    public function assessmentWhychooseSection()
    {
        $assessmentWhyChoose = AssessmentWhyChoose::all();
        return view('assessment-section.whychoose', compact('assessmentWhyChoose'));
    }

    public function saveWhychooseSection(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'first_button_content' => 'nullable|string|max:255', // Allow content as string, with a max length
            'first_button_link' => 'nullable|required_with:first_button_content',
            'second_button_content' => 'nullable|string|max:255',
            'second_button_link' => 'nullable|required_with:second_button_content',
            'description' => 'required|string|min:100|max:2000', // Min length 50, Max length 2000
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'nullable|string|max:255', // Ensure subtitles are strings and with max length
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'nullable|string|max:500', // Each sub-description is a string with max length 500
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048', // Max size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',

            'first_button_content.string' => 'The first button content must be a valid string.',
            'first_button_content.max' => 'The first button content must not exceed 255 characters.',
            'first_button_link.required_with' => 'The first button link is required when button content is provided.',

            'second_button_content.string' => 'The second button content must be a valid string.',
            'second_button_content.max' => 'The second button content must not exceed 255 characters.',
            'second_button_link.required_with' => 'The second button link is required when button content is provided.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',

            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_title.*.max' => 'Each subtitle must not exceed 255 characters.',

            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.max' => 'Each sub-description must not exceed 500 characters.',

            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image must not exceed 2MB in size.',
        ]);


        $assessmentWhyChoose = $request->id
            ? AssessmentWhyChoose::find($request->id)
            : new AssessmentWhyChoose();

        $pointers = [];
        if ($request->has('sub_title')) {
            foreach ($request->sub_title as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
                ];
            }
        }

        $assessmentWhyChoose->title = $request->title;
        $assessmentWhyChoose->description = $request->description;
        $assessmentWhyChoose->first_button_content = $request->first_button_content;
        $assessmentWhyChoose->first_button_link = $request->first_button_link;
        $assessmentWhyChoose->second_button_content = $request->second_button_content;
        $assessmentWhyChoose->second_button_link = $request->second_button_link;
        $assessmentWhyChoose->status = $request->status ?? "off";
        $assessmentWhyChoose->pointers = json_encode($pointers);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('assessment', $imageName, 'public');
            $assessmentWhyChoose->image = 'storage/' . $imagePath;
        }


        $assessmentWhyChoose->save();
        return redirect()->route('assessment-whychoose-section')->with('success', 'Assessment details saved successfully.');
    }

    public function assessmentOurDiagnosticServicesSection()
    {
        $ourDiagnostic = AssessmentOurDiagnosticService::all();
        return view('assessment-section.ourdiagnosticservices', compact('ourDiagnostic'));
    }


    public function saveOurDiagnosticServices(Request $request)
    {

    
        // Retrieve or create a new section
        $adhdfirstSection = $request->id
            ? AssessmentOurDiagnosticService::find($request->id)
            : new AssessmentOurDiagnosticService();

        $pointers = [];

        // If there are pointer titles, process them
        if (!empty($request->pointerTitle) && is_array($request->pointerTitle)) {
            foreach ($request->pointerTitle as $index => $pointerTitle) {
                $subImagePath = null;

                // Handle image upload for each pointer
                if (isset($request->file('image')[$index]) && $request->file('image')[$index]->isValid()) {
                    $imageName = time() . '_' . $request->file('image')[$index]->getClientOriginalName();
                    $subImagePath = $request->file('image')[$index]->storeAs('assessment', $imageName, 'public');
                    $subImagePath = 'storage/' . $subImagePath;
                } elseif (isset($adhdfirstSection->pointers)) {
                    // Fetch existing pointer image if available
                    $existingPointers = json_decode($adhdfirstSection->pointers, true);
                    $subImagePath = $existingPointers[$index]['sub_image'] ?? null;
                }

                // Prepare sub-pointer data
                $subPointers = [];
                if (isset($request->pointerSubTitle[$index]) && isset($request->pointerSubDescription[$index])) {
                    foreach ($request->pointerSubTitle[$index] as $subIndex => $subTitle) {
                        $subPointers[] = [
                            'pointerSubTitle1' => $subTitle,
                            'pointerSubDescription1' => $request->pointerSubDescription[$index][$subIndex] ?? null,
                        ];
                    }
                }

                // Add pointer to the array
                $pointers[] = [
                    'pointerTitle' => $pointerTitle,
                    'pointerDescription' => $request->pointerDescription[$index] ?? null,
                    'sub_image' => $subImagePath,
                    'button1Text' => $request->button1Text[$index] ?? null,
                    'button1Link' => $request->button1Link[$index] ?? null,
                    'button2Text' => $request->button2Text[$index] ?? null,
                    'button2Link' => $request->button2Link[$index] ?? null,
                    'sub_pointer' => $subPointers, // Add sub-pointers here
                ];
            }
        }

        // Save the main section data
        $adhdfirstSection->title = $request->title;
        $adhdfirstSection->description = $request->description ?? null;
        $adhdfirstSection->pointers = json_encode($pointers); // Save pointers as JSON
        $adhdfirstSection->status = $request->status ?? "off";
        $adhdfirstSection->save();

        return redirect()->route('assessment-our-diagnostic-services-section')->with('success', 'Details saved successfully.');
    }
    
    
    public function understandingConditionsSection()
    {
        $ourDiagnostic = AssessmentUnderstandingCondition::all();
        return view('assessment-section.understandingconditions', compact('ourDiagnostic'));
    }

    public function saveUnderstandingConditions(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|min:3|max:255',
            'description' => 'required|string|min:100|max:2000',
            'sub_title' => 'required|array',
            'sub_title.*' => 'required|string|min:3|max:255',
            'sub_description' => 'required|array',
            'sub_description.*' => 'required|string|min:10|max:1000',
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',

            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.min' => 'The subtitle must be at least 3 characters.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',

            'sub_title.required' => 'The sub_title field is required.',
            'sub_title.array' => 'The sub_title must be an array.',
            'sub_title.*.required' => 'Each sub-title is required.',
            'sub_title.*.string' => 'Each sub-title must be a string.',
            'sub_title.*.min' => 'Each sub-title must be at least 3 characters.',
            'sub_title.*.max' => 'Each sub-title must not exceed 255 characters.',

            'sub_description.required' => 'The sub_description field is required.',
            'sub_description.array' => 'The sub_description must be an array.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'sub_description.*.string' => 'Each sub-description must be a string.',
            'sub_description.*.min' => 'Each sub-description must be at least 10 characters.',
            'sub_description.*.max' => 'Each sub-description must not exceed 1000 characters.',
        ]);

       
        $adhdfirstSection = $request->id
            ? AssessmentUnderstandingCondition::find($request->id)
            : new AssessmentUnderstandingCondition();

        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {

                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
                    'button_content' => $request->button_content[$index] ?? null,
                    'button_link' => $request->button_link[$index] ?? null,

                ];
            }
        }


        $adhdfirstSection->title = $request->title;
        $adhdfirstSection->subtitle = $request->subtitle;
        $adhdfirstSection->description = $request->description; // Handle nullable description
        $adhdfirstSection->status = $request->status ?? "off";
        $adhdfirstSection->pointers = json_encode($pointers);


        if (!$adhdfirstSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }

        return redirect()->route('understanding-conditions-section')->with('success', 'Details saved successfully.');
    }
}
