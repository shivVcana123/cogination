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

    public function saveOurStorySection(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'button_content' => 'nullable',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required',
        ], [
            'title.required' => 'The title field is required.',
            'subtitle.required' => 'The subtitle field is required.',
            'button_content.required' => 'The second title must be a valid string.',
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'description' => 'The description field is required.',
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
        $validated = $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'title.required' => 'The title field is required.',
            'image.mimes' => 'The second image must be a file of type: jpeg, png, jpg, gif,svg, webp.',
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string|max:2000', // Increased limit for better flexibility
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required|string|max:255', // Ensures each subtitle is required
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required|string|max:255', // Each sub-description can be null but must be a string
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Added max file size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'subtitle.string' => 'The subtitle must be a valid string.',
            'description.string' => 'The description must be a valid string.',
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif,svg, webp.',
        ]);
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
