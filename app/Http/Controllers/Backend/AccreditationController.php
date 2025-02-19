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
            'title' => 'required|string|min:3|max:255',
            'button_content' => 'nullable|string|min:3|max:255',
            'button_link' => 'nullable|required_with:button_content|max:500',
            'description' => 'required|string|min:100|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Max file size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
        
            'button_content.min' => 'The button content must be at least 3 characters.',
            'button_content.max' => 'The button content must not exceed 255 characters.',
        
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'button_link.max' => 'The button link must not exceed 500 characters.',
        
            'description.required' => 'The description field is required.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 1000 characters.',
        
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
        ]);
        
        // Fetch or create a new section
        $ourCommitmentSection = $request->id
            ? AccreditationOurCommitment::find($request->id)
            : new AccreditationOurCommitment();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $ourCommitmentSection->image = 'storage/' . $imagePath;
        }
        // Assign data
        $ourCommitmentSection->title = $request->title;
        $ourCommitmentSection->description = $request->description;
        $ourCommitmentSection->button_content = $request->button_content;
        $ourCommitmentSection->button_link = $request->button_link;
        $ourCommitmentSection->status = $request->status ?? "off";
        $ourCommitmentSection->page = 'Accreditation & Certifications';
        $ourCommitmentSection->url = 'accreditation';
        $ourCommitmentSection->save();

        return redirect()->route('our-commitment-section')->with('success', 'Adhd details saved successfully.');
    }

    public function certificationsSection(){
        $certificationsSection = AccreditationCertification::get();
        return view('accreditation-section.certifications',compact('certificationsSection'));
    }

    public function saveCertificationsSection(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|min:3|max:255',
            'description' => 'required|string|min:100|max:1000',
            
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required|string|min:3|max:255', // Ensures each subtitle is required and within length constraints
            
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required|string|min:10|max:1000', // Ensures each sub-description follows constraints
        
        ], [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
        
            'subtitle.min' => 'The subtitle must be at least 3 characters.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
        
            'description.required' => 'The description field is required.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 1000 characters.',
        
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_title.*.min' => 'Each subtitle must be at least 3 characters.',
            'sub_title.*.max' => 'Each subtitle must not exceed 255 characters.',
        
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.min' => 'Each sub-description must be at least 10 characters.',
            'sub_description.*.max' => 'Each sub-description must not exceed 1000 characters.',
        ]);
        
        $certificationsSection = $request->id
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
        
    
        $certificationsSection->title = $request->title;
        $certificationsSection->subtitle = $request->subtitle;
        $certificationsSection->description =$request->description; // Handle nullable description
        $certificationsSection->status = $request->status ?? "off";
        $certificationsSection->page = 'Accreditation & Certifications';
        $certificationsSection->url = 'accreditation';
        $certificationsSection->pointers = json_encode($pointers);
        
    
        if (!$certificationsSection->save()) {
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
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|min:3|max:255',
            'description' => 'required|string|min:100|max:1000',
            
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required|string|min:3|max:255', // Ensures each subtitle is required and within length constraints
            
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required|string|min:10|max:1000', // Ensures each sub-description follows constraints
        
        ], [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
        
            'subtitle.min' => 'The subtitle must be at least 3 characters.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
        
            'description.required' => 'The description field is required.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 1000 characters.',
        
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_title.*.min' => 'Each subtitle must be at least 3 characters.',
            'sub_title.*.max' => 'Each subtitle must not exceed 255 characters.',
        
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.min' => 'Each sub-description must be at least 10 characters.',
            'sub_description.*.max' => 'Each sub-description must not exceed 1000 characters.',
        ]);
        

        $accreditationsSection = $request->id
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
        
    
        $accreditationsSection->title = $request->title;
        $accreditationsSection->subtitle = $request->subtitle;
        $accreditationsSection->description = $request->description; // Handle nullable description
        $accreditationsSection->status = $request->status ?? "off";
        $accreditationsSection->page = 'Accreditation & Certifications';
        $accreditationsSection->url = 'accreditation';
        $accreditationsSection->pointers = json_encode($pointers);
        
    
        if (!$accreditationsSection->save()) {
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
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|min:3|max:255',
            
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required|string|min:3|max:255', // Ensures each subtitle is required and has length constraints
            
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required|string|min:10|max:1000', // Ensures each sub-description follows constraints
        
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
        
            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.min' => 'The subtitle must be at least 3 characters.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
        
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_title.*.min' => 'Each subtitle must be at least 3 characters.',
            'sub_title.*.max' => 'Each subtitle must not exceed 255 characters.',
        
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.min' => 'Each sub-description must be at least 10 characters.',
            'sub_description.*.max' => 'Each sub-description must not exceed 1000 characters.',
        ]);
        

        $accreditationsSection = $request->id
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
        
    
        $accreditationsSection->title = $request->title;
        $accreditationsSection->subtitle = $request->subtitle;
        $accreditationsSection->status = $request->status ?? "off";
        $accreditationsSection->page = 'Accreditation & Certifications';
        $accreditationsSection->url = 'accreditation';
        $accreditationsSection->pointers = json_encode($pointers);
        
    
        if (!$accreditationsSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }
    
        return redirect()->route('specialized-certifications-section')->with('success', 'Details saved successfully.');
    }
    
    public function ourTeamContinuousSection(){
        $ourTeamContinuousSection = AccreditationOurTeamContinuous::get();
        return view('accreditation-section.ourteamcontinuous',compact('ourTeamContinuousSection'));
    }

    public function saveOurTeamContinuousSection(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            // 'button_content' => 'nullable|string|min:3|max:255',
            // 'button_link' => 'nullable|required_with:button_content|max:500',
            'description' => 'required|string|min:100|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Max file size 2MB
        
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
        
            'button_content.string' => 'The button content must be a valid string.',
            'button_content.min' => 'The button content must be at least 3 characters.',
            'button_content.max' => 'The button content must not exceed 255 characters.',
        
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'button_link.max' => 'The button link must not exceed 500 characters.',
        
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
        
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
        ]);
        


        // Fetch or create a new section
        $ourTeamContinuousSection = $request->id
            ? AccreditationOurTeamContinuous::find($request->id)
            : new AccreditationOurTeamContinuous();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $ourTeamContinuousSection->image = 'storage/' . $imagePath;
        }
  

        // Assign data
        $ourTeamContinuousSection->title = $request->title;
        $ourTeamContinuousSection->description = $request->description;
        // $ourTeamContinuousSection->button_content = $request->button_content;
        // $ourTeamContinuousSection->button_link = $request->button_link;
        $ourTeamContinuousSection->status = $request->status ?? "off";
        $ourTeamContinuousSection->page = 'Accreditation & Certifications';
        $ourTeamContinuousSection->url = 'accreditation';
        $ourTeamContinuousSection->save();
   

        return redirect()->route('our-team-continuous-section')->with('success', 'Adhd details saved successfully.');
    }
    
}
