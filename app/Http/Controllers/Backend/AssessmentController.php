<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentOurDiagnosticService;
use App\Models\AssessmentUnderstandingCondition;
use App\Models\AssessmentWhyChoose;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function assessmentSection(){
        $assessmentSection = Assessment::all();
        return view('assessment-section.assessment',compact('assessmentSection'));
    }

    public function saveAssessmentSection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'button_content' => 'required|string|max:255',
            'button_link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        // Fetch or create a new section
        $assessmentSection = $request->id
            ? Assessment::find($request->id)
            : new Assessment();



        // Assign data
        $assessmentSection->title = $validated['title'];
        $assessmentSection->subtitle = $validated['subtitle'];
        $assessmentSection->description = $validated['description'];
        $assessmentSection->button_content = $validated['button_content'];
        $assessmentSection->button_link = $validated['button_link'];
        
        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('assessment', $imageName, 'public');
            $assessmentSection->image = 'storage/' . $imagePath;
        }

        $assessmentSection->save();

        return redirect()->route('assessment-section')->with('success', 'Adhd details saved successfully.');
    }

    public function assessmentWhychooseSection(){
        $assessmentWhyChoose = AssessmentWhyChoose::all();
        return view('assessment-section.whychoose',compact('assessmentWhyChoose'));
    }

    public function saveWhychooseSection(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'first_button_content' => 'nullable|string|max:255',
            'first_button_link' => 'nullable|string|max:255',
            'second_button_content' => 'nullable|string|max:255',
            'second_button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'string|max:255',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'string',
        ]);
        // $validated = $request->all();
        try {
        $assessmentWhyChoose = $request->id
            ? AssessmentWhyChoose::find($request->id)
            : new AssessmentWhyChoose();
    
        $pointers = [];
        if ($request->has('sub_title')) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                ];
            }
        }
    
        $assessmentWhyChoose->title = $validated['title'];
        $assessmentWhyChoose->description = $validated['description'];
        $assessmentWhyChoose->first_button_content = $validated['first_button_content'];
        $assessmentWhyChoose->first_button_link = $validated['first_button_link'];
        $assessmentWhyChoose->second_button_content = $validated['second_button_content'];
        $assessmentWhyChoose->second_button_link = $validated['second_button_link'];
        $assessmentWhyChoose->pointers = json_encode($pointers);
    
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('assessment', $imageName, 'public');
            $assessmentWhyChoose->image = 'storage/' . $imagePath;
        }
    
   
            $assessmentWhyChoose->save();
            return redirect()->route('assessment-whychoose-section')->with('success', 'Assessment details saved successfully.');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the assessment.');
        }
    }

    public function assessmentOurDiagnosticServicesSection(){
        $ourDiagnostic = AssessmentOurDiagnosticService::all();
        return view('assessment-section.ourdiagnosticservices',compact('ourDiagnostic'));
    }

    // public function saveOurDiagnosticServices(Request $request)
    // {
    //     // dd($request->all());
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string|max:255',
    //         'sub_title' => 'required|array',
    //         'sub_title.*' => 'nullable|string|max:255',
    //         'sub_description' => 'nullable|array',
    //         'sub_description.*' => 'nullable|string',
    //         'button_content_1' => 'nullable|array',
    //         'button_content_1.*' => 'nullable|string|max:255',
    //         'button_link_1' => 'nullable|array',
    //         'button_link_1.*' => 'nullable|string|max:255',
    //         'button_content_2' => 'nullable|array',
    //         'button_content_2.*' => 'nullable|string|max:255',
    //         'button_link_2' => 'nullable|array',
    //         'button_link_2.*' => 'nullable|string|max:255',
    //         'image' => 'nullable|array',
    //         'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
    //     ]);
    
    //     $adhdfirstSection = $request->id
    //         ? AssessmentOurDiagnosticService::find($request->id)
    //         : new AssessmentOurDiagnosticService();
    
    //     $pointers = [];
    //     if (!empty($validated['sub_title'])) {
    //         foreach ($validated['sub_title'] as $index => $subTitle) {
    //             // Default to null if no image
    //             $subImagePath = null;
    //               // Handle image upload if provided
    //               if (isset($request->file('image')[$index]) && $request->file('image')[$index]->isValid()) {
    //                 $imageName = time() . '_' . $request->file('image')[$index]->getClientOriginalName();
    //                 $subImagePath = $request->file('image')[$index]->storeAs('assessment', $imageName, 'public');
    //                 $subImagePath = 'storage/' . $subImagePath;
    //             } elseif (isset($adhdfirstSection->pointers)) {
    //                 $existingPointers = json_decode($adhdfirstSection->pointers, true);
    //                 $subImagePath = $existingPointers[$index]['sub_image'] ?? null;
    //             }
        
    //             // Append pointer data, including all buttons and updated sub_image
    //             $pointers[] = [
    //                 'sub_title' => $subTitle,
    //                 'sub_description' => $validated['sub_description'][$index] ?? null,
    //                 'sub_image' => $subImagePath, // Only updated if a new image was uploaded or kept the old one
    //                 'button_content_1' => $validated['button_content_1'][$index] ?? null,
    //                 'button_link_1' => $validated['button_link_1'][$index] ?? null,
    //                 'button_content_2' => $validated['button_content_2'][$index] ?? null,
    //                 'button_link_2' => $validated['button_link_2'][$index] ?? null,
    //             ];
    //         }
    //     }
        
        
        
        
    
    //     $adhdfirstSection->title = $validated['title'];
    //     $adhdfirstSection->description = $validated['description'] ?? null; // Handle nullable description
    //     $adhdfirstSection->pointers = json_encode($pointers);
        
    
    //     if (!$adhdfirstSection->save()) {
    //         return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
    //     }
    
    //     return redirect()->route('assessment-our-diagnostic-services-section')->with('success', 'Details saved successfully.');
    // }
    

//     public function saveOurDiagnosticServices(Request $request)
//     {
//         // dd($request->all());
//         try {
//             // Retrieve or create a new section
//             $adhdfirstSection = $request->id
//                 ? AssessmentOurDiagnosticService::find($request->id)
//                 : new AssessmentOurDiagnosticService();
    
//             $pointers = [];
    
//             // If there are pointer titles, process them
//             if (!empty($request->pointerTitle) && is_array($request->pointerTitle)) {
//                 foreach ($request->pointerTitle as $index => $pointerTitle) {
//                     $subImagePath = null;
    
//                     // Handle image upload for each pointer
//                     if (isset($request->file('image')[$index]) && $request->file('image')[$index]->isValid()) {
//                         $imageName = time() . '_' . $request->file('image')[$index]->getClientOriginalName();
//                         $subImagePath = $request->file('image')[$index]->storeAs('assessment', $imageName, 'public');
//                         $subImagePath = 'storage/' . $subImagePath;
//                     } elseif (isset($adhdfirstSection->pointers)) {
//                         // If the section exists, fetch the existing pointer image
//                         $existingPointers = json_decode($adhdfirstSection->pointers, true);
//                         $subImagePath = $existingPointers[$index]['sub_image'] ?? null;
//                     }
    
// // Initialize the new array for sub-pointer titles and descriptions
// $newArray = [];

// // Ensure pointerSubTitle and pointerSubDescription are arrays
// if (isset($request->pointerSubTitle) && isset($request->pointerSubDescription) && is_array($request->pointerSubTitle) && is_array($request->pointerSubDescription)) {
//     // Loop through the pointerSubTitle array assuming it has multiple sets of titles and descriptions
//     $pointerCount = count($request->pointerSubTitle[0]);  // Assuming both arrays are of the same length

//     for ($i = 0; $i < $pointerCount; $i++) {
//         // Add both title and description to the new array as pairs
//         $newArray[] = [
//             'pointerSubTitle1' => $request->pointerSubTitle[0][$i] ?? null,
//             'pointerSubDescription1' => $request->pointerSubDescription[0][$i] ?? null,
//         ];
//     }
// }


// dd($newArray);
// $pointers[] = [
//     'pointerTitle' => $pointerTitle,
//     'pointerDescription' => $request->pointerDescription[$index] ?? null,
//     'sub_image' => $subImagePath,
//     'button1Text' => $request->button1Text[$index] ?? null,
//     'button1Link' => $request->button1Link[$index] ?? null,
//     'button2Text' => $request->button2Text[$index] ?? null,
//     'button2Link' => $request->button2Link[$index] ?? null,
//     'sub_pointer' => $newArray, // Correctly pass the sub-pointer data
// ];
//                 }
//             }
    
//             // dd($pointers);
//             // Save the main section data
//             $adhdfirstSection->title = $request->title;
//             $adhdfirstSection->description = $request->description ?? null;
//             $adhdfirstSection->pointers = json_encode($pointers); // Save pointers as JSON
//             $adhdfirstSection->save();
    
//             return redirect()->route('assessment-our-diagnostic-services-section')->with('success', 'Details saved successfully.');
//         } catch (\Exception $e) {
//             dd($e);
//             // Optionally log the exception message
//             // Log::error($e->getMessage());
    
//             return redirect()->back()->withErrors(['error' => 'An error occurred while saving the record. Please try again later.']);
//         }
//     }
    
   
public function saveOurDiagnosticServices(Request $request)
{
    try {
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
        $adhdfirstSection->save();

        return redirect()->route('assessment-our-diagnostic-services-section')->with('success', 'Details saved successfully.');
    } catch (\Exception $e) {
        // Optionally log the exception message
        \Log::error($e->getMessage());

        return redirect()->back()->withErrors(['error' => 'An error occurred while saving the record. Please try again later.']);
    }
}


public function understandingConditionsSection(){
        $ourDiagnostic = AssessmentUnderstandingCondition::all();
        return view('assessment-section.understandingconditions',compact('ourDiagnostic'));
    }

    public function saveUnderstandingConditions(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'nullable|string|max:255',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'nullable|string',
            'button_content' => 'nullable|array',
            'button_content.*' => 'nullable|string|max:255',
            'button_link' => 'nullable|array',
            'button_link.*' => 'nullable|string|max:255',
  
        ]);
    
        $adhdfirstSection = $request->id
            ? AssessmentUnderstandingCondition::find($request->id)
            : new AssessmentUnderstandingCondition();
    
        $pointers = [];
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                    'button_content' => $validated['button_content'][$index] ?? null,
                    'button_link' => $validated['button_link'][$index] ?? null,
                    
                ];
            }
        }
        
    
        $adhdfirstSection->title = $validated['title'];
        $adhdfirstSection->subtitle = $validated['subtitle'];
        $adhdfirstSection->description = $validated['description']; // Handle nullable description
        $adhdfirstSection->pointers = json_encode($pointers);
        
    
        if (!$adhdfirstSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }
    
        return redirect()->route('understanding-conditions-section')->with('success', 'Details saved successfully.');
    }
    
}
