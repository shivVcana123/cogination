<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUsJoinCommunity;
use App\Models\AboutUsOurMission;
use App\Models\AboutUsOurStory;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function ourStorySection(){
        $ourStorySection = AboutUsOurStory::all();
        return view('about-section.ourstory',compact('ourStorySection'));
    }

    public function saveOurStorySection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'button_content' => 'required|string|max:255',
            'button_link' => 'required|string|max:255',
            'first_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        // Fetch or create a new section
        $autismSection = $request->id
            ? AboutUsOurStory::find($request->id)
            : new AboutUsOurStory();

        // Handle first image upload
        if ($request->hasFile('first_image') && $request->file('first_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('first_image')->getClientOriginalName();
            $imagePath = $request->file('first_image')->storeAs('about', $imageName, 'public');
            $autismSection->first_image = 'storage/' . $imagePath;
        }
        if ($request->hasFile('second_image') && $request->file(key: 'second_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('second_image')->getClientOriginalName();
            $imagePath = $request->file('second_image')->storeAs('about', $imageName, 'public');
            $autismSection->second_image = 'storage/' . $imagePath;
        }

        // Assign data
        $autismSection->title = $validated['title'];
        $autismSection->subtitle = $validated['subtitle'];
        $autismSection->description = $validated['description'];
        $autismSection->button_content = $validated['button_content'];
        $autismSection->button_link = $validated['button_link'];

        $autismSection->save();
   

        return redirect()->route('our-story-section')->with('success', 'Adhd details saved successfully.');
    }

    public function ourMissionSection(){
        $ourMissionSection = AboutUsOurMission::all();
        return view('about-section.ourmission',compact('ourMissionSection'));
    }

    public function saveOurMissionSection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        // Fetch or create a new section
        $autismSection = $request->id
            ? AboutUsOurMission::find($request->id)
            : new AboutUsOurMission();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time().'_'.uniqid().'_'.$request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $autismSection->image = 'storage/'.$imagePath;
        }
        


        // Assign data
        $autismSection->title = $validated['title'];

        $autismSection->save();
   

        return redirect()->route('our-mission-section')->with('success', 'Adhd details saved successfully.');
    }

    public function joinCommunitySection(){
        $joinCommunitySection = AboutUsJoinCommunity::all();
        return view('about-section.joincommunity',compact('joinCommunitySection'));
    }

    public function savejoinCommunitySection(Request $request)
    {
        // Dump and Die for Debugging (optional)
        // dd($request->all());
        
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'string|max:255', // Validate each sub_title
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'string|nullable', // Validate each sub_description
        ]);
    
        // Fetch or create a new section
        $autismSection = $request->id
            ? AboutUsJoinCommunity::find($request->id)
            : new AboutUsJoinCommunity();
    
        // Prepare pointers
        $pointers = [];
        if (!empty($validated['sub_title'])) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                ];
            }
        }
    
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $autismSection->image = 'storage/' . $imagePath;
        }
    
        // Assign data to the model
        $autismSection->title = $validated['title'];
        $autismSection->subtitle = $validated['subtitle'];
        $autismSection->description = $validated['description'];
        $autismSection->pointers = json_encode($pointers, JSON_THROW_ON_ERROR);
    
        // Save the model
        $autismSection->save();
    
        // Redirect with success message
        return redirect()->route('join-community-section')
            ->with('success', 'Adhd details saved successfully.');
    }

    

}
