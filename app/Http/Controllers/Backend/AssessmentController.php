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
    public function assessmentSection(){
        $assessmentSection = Assessment::all();
        return view('assessment-section.assessment',compact('assessmentSection'));
    }

    public function saveAssessmentSection(TitleRequest $request)
    {
        // dd($request->all());
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

    public function assessmentWhychooseSection(){
        $assessmentWhyChoose = AssessmentWhyChoose::all();
        return view('assessment-section.whychoose',compact('assessmentWhyChoose'));
    }

    public function saveWhychooseSection(TitleRequest $request)
    {
        try {
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
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the assessment.');
        }
    }

    public function assessmentOurDiagnosticServicesSection(){
        $ourDiagnostic = AssessmentOurDiagnosticService::all();
        return view('assessment-section.ourdiagnosticservices',compact('ourDiagnostic'));
    }

public function saveOurDiagnosticServices(TitleRequest $request)
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
        $adhdfirstSection->status = $request->status ?? "off";
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

    public function saveUnderstandingConditions(TitleRequest $request)
    {
        // dd($request->all());
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
