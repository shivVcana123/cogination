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
            'title' => 'required|min:3|max:255',
            'subtitle' => 'nullable|min:3|max:255',
            'button_content' => 'nullable|min:3|max:255',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required|min:100|max:2000', // Increased max length for flexibility
        ], [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
            'subtitle.min' => 'The subtitle must be at least 3 characters.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
            'button_content.min' => 'The button content must be at least 3 characters.',
            'button_content.max' => 'The button content must not exceed 255 characters.',
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'description.required' => 'The description field is required.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
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

    public function saveOurMissionSection(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
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

    public function savejoinCommunitySection(Request $request)
    {     
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|min:3|max:255',
            'description' => 'required|string|min:100|max:2000', // Min 10 characters for meaningful content
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required|string|min:3|max:255', // Each subtitle must have at least 3 characters
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required|string|min:3|max:255', // Each sub-description must have at least 3 characters
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // 2MB file size limit
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters long.',
            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.min' => 'The subtitle must be at least 3 characters long.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters long.',
            'sub_title.required' => 'Each subtitle is required.',
            'sub_title.array' => 'The subtitles must be an array.',
            'sub_title.*.required' => 'Each subtitle is required and must be a string.',
            'sub_title.*.string' => 'Each subtitle must be a valid string.',
            'sub_title.*.min' => 'Each subtitle must be at least 3 characters long.',
            'sub_description.array' => 'The sub-descriptions must be an array.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.min' => 'Each sub-description must be at least 3 characters long.',
            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
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
