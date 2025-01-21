<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
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

    public function saveOurStorySection(TitleRequest $request)
    {

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
        $autismSection->title = $request->title;
        $autismSection->subtitle = $request->subtitle;
        $autismSection->description =$request->description;
        $autismSection->button_content = $request->button_content;
        $autismSection->button_link = $request->button_link;
        $autismSection->status = $request->status ?? "off";
        $autismSection->save();
        return redirect()->route('our-story-section')->with('success', 'Adhd details saved successfully.');
    }

    public function ourMissionSection(){
        $ourMissionSection = AboutUsOurMission::all();
        return view('about-section.ourmission',compact('ourMissionSection'));
    }

    public function saveOurMissionSection(TitleRequest $request)
    {
        // dd($request->all());

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
        $autismSection->title = $request->title;
        $autismSection->status = $request->status ?? "off";

        $autismSection->save();
   

        return redirect()->route('our-mission-section')->with('success', 'Adhd details saved successfully.');
    }

    public function joinCommunitySection(){
        $joinCommunitySection = AboutUsJoinCommunity::all();
        return view('about-section.joincommunity',compact('joinCommunitySection'));
    }

    public function savejoinCommunitySection(TitleRequest $request)
    {        
        // dd($request->all());
        // Fetch or create a new section
        $autismSection = $request->id
            ? AboutUsJoinCommunity::find($request->id)
            : new AboutUsJoinCommunity();
    
        // Prepare pointers
        $pointers = [];
        if (!empty($request->sub_title)) {
            foreach ($request->sub_title as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $request->sub_description[$index] ?? null,
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
        $autismSection->title = $request->title;
        $autismSection->subtitle = $request->subtitle;
        $autismSection->description = $request->description;
        $autismSection->status = $request->status ?? "off";
        $autismSection->pointers = json_encode($pointers, JSON_THROW_ON_ERROR);
    
        // Save the model
        $autismSection->save();
    
        // Redirect with success message
        return redirect()->route('join-community-section')
            ->with('success', 'Adhd details saved successfully.');
    }

    

}
