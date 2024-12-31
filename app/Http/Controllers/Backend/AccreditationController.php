<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        $autismSection->save();

        return redirect()->route('our-commitment-section')->with('success', 'Adhd details saved successfully.');
    }

    public function certificationsSection(){
        $certificationsSection = AccreditationCertification::get();
        return view('accreditation-section.certifications',compact('certificationsSection'));
    }

    public function saveCertificationsSection(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'nullable|string|max:255',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'nullable|string',
  
        ]);
    
        $adhdfirstSection = $request->id
            ? AccreditationCertification::find($request->id)
            : new AccreditationCertification();
    
        $pointers = [];
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                ];
            }
        }
        
    
        $adhdfirstSection->title = $request->title;
        $adhdfirstSection->subtitle = $request->subtitle;
        $adhdfirstSection->description =$request->description; // Handle nullable description
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
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'nullable|string|max:255',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'nullable|string',
  
        ]);
    
        $adhdfirstSection = $request->id
            ? AccreditationAccreditation::find($request->id)
            : new AccreditationAccreditation();
    
        $pointers = [];
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
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
    
        return redirect()->route('accreditations-section')->with('success', 'Details saved successfully.');
    }

    public function specializedCertificationsSection(){
        $accreditationsSection = AccreditationSpecializedCertification::get();
        return view('accreditation-section.specializedcertifications',compact('accreditationsSection'));
    }

    public function saveSpecializedCertifications(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'nullable|string|max:255',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'nullable|string',
  
        ]);
    
        $adhdfirstSection = $request->id
            ? AccreditationSpecializedCertification::find($request->id)
            : new AccreditationSpecializedCertification();
    
        $pointers = [];
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
    
                // Append pointer data, including all buttons
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                ];
            }
        }
        
    
        $adhdfirstSection->title = $validated['title'];
        $adhdfirstSection->subtitle = $validated['subtitle'];
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

    public function saveOurTeamContinuousSection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_content' => 'required|string|max:255',
            'button_link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);



        
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
        $autismSection->title = $validated['title'];
        $autismSection->description = $validated['description'];
        $autismSection->button_content = $validated['button_content'];
        $autismSection->button_link = $validated['button_link'];

        $autismSection->save();
   

        return redirect()->route('our-team-continuous-section')->with('success', 'Adhd details saved successfully.');
    }
    
}
