<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\AccreditationAccreditation;
use App\Models\AccreditationCertification;
use App\Models\AccreditationOurCommitment;
use App\Models\AccreditationOurTeamContinuous;
use App\Models\AccreditationSpecializedCertification;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    public function ourCommitmentSection(){
        $ourCommitmentSection = AccreditationOurCommitment::get();
        return view('accreditation-section.ourcommitment',compact('ourCommitmentSection'));
    }

    public function saveOurCommitmentSection(Request $request)
    {
       
        $validated = $request->validate([
            'title' => 'required',
            'button_content' => 'nullable',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Added max file size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'subtitle.required' => 'The subtitle field is required.',
            'button_content.required' => 'The second title must be a valid string.',
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'description' => 'The description field is required.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif,svg, webp.',
        ]);
        // Fetch or create a new section
        $autismSection = $request->id
            ? AccreditationOurCommitment::find($request->id)
            : new AccreditationOurCommitment();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $autismSection->image = 'storage/' . $imagePath;
        }
        // Assign data
        $autismSection->title = $request->title;
        $autismSection->description = $request->description;
        $autismSection->button_content = $request->button_content;
        $autismSection->button_link = $request->button_link;
        $autismSection->status = $request->status ?? "off";
        $autismSection->save();

        return redirect()->route('our-commitment-section')->with('success', 'Adhd details saved successfully.');
    }

    public function certificationsSection(){
        $certificationsSection = AccreditationCertification::get();
        return view('accreditation-section.certifications',compact('certificationsSection'));
    }

    public function saveCertificationsSection(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'description' => 'required',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required', // Ensures each subtitle is required
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required', // Each sub-description can be null but must be a string

        ], [
            'title.required' => 'The title field is required.',
            'description' => 'The description field is required.',
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',

        ]);
        $adhdfirstSection = $request->id
            ? AccreditationCertification::find($request->id)
            : new AccreditationCertification();
    
        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
                ];
            }
        }
        
    
        $adhdfirstSection->title = $request->title;
        $adhdfirstSection->subtitle = $request->subtitle;
        $adhdfirstSection->description =$request->description; // Handle nullable description
        $adhdfirstSection->status = $request->status ?? "off";
        $adhdfirstSection->pointers = json_encode($pointers);
        
    
        if (!$adhdfirstSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }
    
        return redirect()->route('certifications-section')->with('success', 'Details saved successfully.');
    }

    public function accreditationsSection(){
        $accreditationsSection = AccreditationAccreditation::get();
        return view('accreditation-section.accreditations',compact('accreditationsSection'));
    }

    public function saveAccreditationsSection(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'description' => 'required',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required', // Ensures each subtitle is required
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required', // Each sub-description can be null but must be a string
        ], [
            'title.required' => 'The title field is required.',
            'description' => 'The description field is required.',
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
        ]);

        dd($request->all());
        $adhdfirstSection = $request->id
            ? AccreditationAccreditation::find($request->id)
            : new AccreditationAccreditation();
    
        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
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
    
        return redirect()->route('accreditations-section')->with('success', 'Details saved successfully.');
    }

    public function specializedCertificationsSection(){
        $accreditationsSection = AccreditationSpecializedCertification::get();
        return view('accreditation-section.specializedcertifications',compact('accreditationsSection'));
    }

    public function saveSpecializedCertifications(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required', // Ensures each subtitle is required
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required', // Each sub-description can be null but must be a string
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'subtitle.string' => 'The subtitle must be a valid string.',
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
           
        ]);

        $adhdfirstSection = $request->id
            ? AccreditationSpecializedCertification::find($request->id)
            : new AccreditationSpecializedCertification();
    
        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
                ];
            }
        }
        
    
        $adhdfirstSection->title = $request->title;
        $adhdfirstSection->subtitle = $request->subtitle;
        $adhdfirstSection->status = $request->status ?? "off";
        $adhdfirstSection->pointers = json_encode($pointers);
        
    
        if (!$adhdfirstSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }
    
        return redirect()->route('specialized-certifications-section')->with('success', 'Details saved successfully.');
    }
    
    public function ourTeamContinuousSection(){
        $ourTeamContinuousSection = AccreditationOurTeamContinuous::get();
        return view('accreditation-section.ourteamcontinuous',compact('ourTeamContinuousSection'));
    }

    public function saveOurTeamContinuousSection(TitleRequest $request)
    {
        
        $validated = $request->validate([
            'title' => 'required',
            'button_content' => 'nullable',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Added max file size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'button_content.required' => 'The second title must be a valid string.',
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'description' => 'The description field is required.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif,svg, webp.',
        ]);

        dd($request->all()); 

        // Fetch or create a new section
        $autismSection = $request->id
            ? AccreditationOurTeamContinuous::find($request->id)
            : new AccreditationOurTeamContinuous();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $autismSection->image = 'storage/' . $imagePath;
        }
  

        // Assign data
        $autismSection->title = $request->title;
        $autismSection->description = $request->description;
        $autismSection->button_content = $request->button_content;
        $autismSection->button_link = $request->button_link;
        $autismSection->status = $request->status ?? "off";

        $autismSection->save();
   

        return redirect()->route('our-team-continuous-section')->with('success', 'Adhd details saved successfully.');
    }
    
}
