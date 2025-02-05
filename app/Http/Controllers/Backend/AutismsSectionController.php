<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AutismsBook;
use App\Models\AutismsProcess;
use App\Models\AutismsScreening;
use App\Models\AutismsSecondSection;
use App\Models\AutismsSection;
use App\Models\CategorySection;
use App\Models\SubCategorySection;
use Illuminate\Http\Request;

class AutismsSectionController extends Controller
{
    public function autismSection(){
        $autismSection = AutismsSection::get();
        return view('autism-section.autismsection',compact('autismSection'));
    }

    public function saveAutismSection(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|min:3|max:255',  
            'first_title' => 'required|string|min:3|max:255',  
            'first_subtitle' => 'nullable|string|min:3|max:255',  
            'first_button_content' => 'nullable|string|min:3|max:255',  
            'first_button_link' => 'nullable|required_with:first_button_content',  
            'first_description' => 'required|string|min:100|max:2000',  
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', 
        ], [
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a valid string.',
            'type.min' => 'The type must be at least 3 characters.',
            'type.max' => 'The type must not exceed 255 characters.',
            
            'first_title.required' => 'The title field is required.',
            'first_title.string' => 'The title must be a valid string.',
            'first_title.min' => 'The title must be at least 3 characters.',
            'first_title.max' => 'The title must not exceed 255 characters.',
            
            'first_subtitle.string' => 'The subtitle must be a valid string.',
            'first_subtitle.min' => 'The subtitle must be at least 3 characters.',
            'first_subtitle.max' => 'The subtitle must not exceed 255 characters.',
            
            'first_button_content.string' => 'The button content must be a valid string.',
            'first_button_content.min' => 'The button content must be at least 3 characters.',
            'first_button_content.max' => 'The button content must not exceed 255 characters.',
            'first_button_link.required_with' => 'The button link is required when button content is provided.',
            
            'first_description.required' => 'The description field is required.',
            'first_description.string' => 'The description must be a valid string.',
            'first_description.min' => 'The description must be at least 100 characters.',
            'first_description.max' => 'The description must not exceed 2000 characters.',
            
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
        ]);
        

        // Fetch or create a new section
        $autismSection = $request->id
            ? AutismsSection::find($request->id)
            : new AutismsSection();


        // Assign data
        $autismSection->type = $validated['type'];
        $autismSection->first_title = $validated['first_title'];
        $autismSection->first_subtitle = $validated['first_subtitle'];
        $autismSection->first_description = $validated['first_description'];
        $autismSection->first_button_content = $validated['first_button_content'];
        $autismSection->first_button_link = $validated['first_button_link'];
    
      
        $autismSection->status = $request->status ?? "off";  

        // Handle first image upload
        if ($request->hasFile('first_image') && $request->file('first_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('first_image')->getClientOriginalName();
            $imagePath = $request->file('first_image')->storeAs('autism', $imageName, 'public');
            $autismSection->first_image = 'storage/' . $imagePath;
        }

    
        // Save the record
        if (!$autismSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }

        return redirect()->route('autism-section')->with('success', 'Adhd details saved successfully.');
    }

    public function fetchAutismsSectionByType(Request $request)
    {
        $type = $request->type;
    
        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $autismSection = AutismsSection::where('type', $type)->get();
        return response()->json(['data' => $autismSection]);
    }

    public function autismSecondSection(){
        $autismSection = AutismsSecondSection::get();
        return view('autism-section.autismsecondsection',compact('autismSection'));
    }

    public function saveAutismSecondSection(Request $request)
    {
    
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string|min:3|max:255',
            'second_title' => 'required|string|min:3|max:255',
            'second_subtitle' => 'nullable|string|min:3|max:255',
            'second_button_content' => 'nullable|string|min:3|max:255',
            'second_button_link' => 'nullable|required_with:second_button_content',
            'second_description' => 'required|string|min:100|max:2000',
            'second_sub_title' => 'nullable|array',
            'second_sub_title.*' => 'required|string|min:3|max:255',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a valid string.',
            'type.min' => 'The type must be at least 3 characters.',
            'type.max' => 'The type must not exceed 255 characters.',
            
            'second_title.required' => 'The second title field is required.',
            'second_title.string' => 'The second title must be a valid string.',
            'second_title.min' => 'The second title must be at least 3 characters.',
            'second_title.max' => 'The second title must not exceed 255 characters.',
            
            'second_subtitle.string' => 'The second subtitle must be a valid string.',
            'second_subtitle.min' => 'The second subtitle must be at least 3 characters.',
            'second_subtitle.max' => 'The second subtitle must not exceed 255 characters.',
            
            'second_button_content.string' => 'The second button content must be a valid string.',
            'second_button_content.min' => 'The second button content must be at least 3 characters.',
            'second_button_content.max' => 'The second button content must not exceed 255 characters.',
            'second_button_link.required_with' => 'The button link is required when button content is provided.',
            
            'second_description.required' => 'The description field is required.',
            'second_description.string' => 'The second description must be a valid string.',
            'second_description.min' => 'The second description must be at least 100 characters.',
            'second_description.max' => 'The second description must not exceed 2000 characters.',
            
            'second_sub_title.array' => 'The second sub-title field must be an array.',
            'second_sub_title.*.required' => 'Each second sub-title is required.',
            'second_sub_title.*.string' => 'Each second sub-title must be a valid string.',
            'second_sub_title.*.min' => 'Each second sub-title must be at least 3 characters.',
            'second_sub_title.*.max' => 'Each second sub-title must not exceed 255 characters.',
            
            'second_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
        ]);
        
        

        // Fetch or create a new section
        $autismSection = $request->id
            ? AutismsSecondSection::find($request->id)
            : new AutismsSecondSection();

        // Handle pointers
        $pointers = [];
        if ($request->has('second_sub_title')) {
            foreach ($validated['second_sub_title'] as $index => $subTitle) {
                $pointers[] = [
                    'second_sub_title' => $subTitle,
                    
                ];
            }
        }

        // Assign data
        $autismSection->type = $validated['type'];
        $autismSection->second_title = $validated['second_title'];
        $autismSection->second_subtitle = $validated['second_subtitle'];
        $autismSection->second_button_content = $validated['second_button_content'];
        $autismSection->second_button_link = $validated['second_button_link'];
        $autismSection->second_description = $validated['second_description'];
        $autismSection->status = $request->status ?? "off";
        $autismSection->pointers = json_encode($pointers);

        // Handle second image upload
        if ($request->hasFile('second_image') && $request->file('second_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('second_image')->getClientOriginalName();
            $imagePath = $request->file('second_image')->storeAs('autism', $imageName, 'public');
            $autismSection->second_image = 'storage/' . $imagePath;
        }

        // Save the record
        if (!$autismSection->save()) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the record.']);
        }

        return redirect()->route('autism-second-section')->with('success', 'Adhd details saved successfully.');
    }

    public function fetchAutismsSecondSectionByType(Request $request)
    {
        $type = $request->type;
    
        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $autismSection = AutismsSecondSection::where('type', $type)->get();
        return response()->json(['data' => $autismSection]);
    }

    public function autismProcessSection(){
        $autismProcess = AutismsProcess::get();
        return view('autism-section.process',compact('autismProcess'));
    }
    public function saveProcessSection(Request $request)
    {
      

        // Validate the request data
        $validated = $request->validate([
            'type' => 'required',
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string|min:100|max:2000',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'required|string|max:255',
            'sub_description' => 'nullable|array',
            'sub_description.*' => 'required|string|max:255',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'type.required' => 'Please select the type.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
            
            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
            
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
            
            'sub_title.array' => 'The sub-title field must be an array.',
            'sub_title.*.required' => 'Each sub-title is required.',
            'sub_title.*.string' => 'Each sub-title must be a valid string.',
            'sub_title.*.max' => 'Each sub-title must not exceed 255 characters.',
            
            'sub_description.array' => 'The sub-description field must be an array.',
            'sub_description.*.required' => 'Each sub-description is required.',
            'sub_description.*.string' => 'Each sub-description must be a valid string.',
            'sub_description.*.max' => 'Each sub-description must not exceed 255 characters.',
            
            'second_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
        ]);
        
        
        // Fetch or create a new section
        $autismSection = $request->id
            ? AutismsProcess::find($request->id)
            : new AutismsProcess();

        // Handle pointers
        $pointers = [];
        if ($request->has('sub_title')) {
            foreach ($validated['sub_title'] as $index => $subTitle) {
                $pointers[] = [
                    'sub_title' => $subTitle,
                    'sub_description' => $validated['sub_description'][$index] ?? null,
                ];
            }
        }

        // Assign data
        $autismSection->type = $validated['type'];
        $autismSection->title = $validated['title'];
        $autismSection->subtitle = $validated['subtitle'];
        $autismSection->description = $validated['description'];
        $autismSection->status = $request->status ?? "off";
        $autismSection->pointers = json_encode($pointers);

        $autismSection->save();
   

        return redirect()->route('autism-process-section')->with('success', 'Adhd details saved successfully.');
    
    }

    public function fetchAutismsProcessSectionByType(Request $request)
    {
        $type = $request->type;
    
        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $autismProcess = AutismsProcess::where('type', $type)->get();
        return response()->json(['data' => $autismProcess]);
    }

    public function autismScreeningSection(){
        $autismScreening = AutismsScreening::get();
        return view('autism-section.screening',compact('autismScreening'));
    }

    public function saveScreeningSection(Request $request)
    {
 
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required',
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_content' => 'nullable|string|max:255',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required|string|min:100|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'type.required' => 'The type field is required.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
            
            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
            
            'button_content.string' => 'The button content must be a valid string.',
            'button_content.max' => 'The button content must not exceed 255 characters.',
            
            'button_link.required_with' => 'The button link is required when button content is provided.',
            
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
            
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
        ]);
        

        // Fetch or create a new section
        $autismSection = $request->id
            ? AutismsScreening::find($request->id)
            : new AutismsScreening();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('autism', $imageName, 'public');
            $autismSection->image = 'storage/' . $imagePath;
        }

        // Assign data
        $autismSection->type = $validated['type'];
        $autismSection->title = $validated['title'];
        $autismSection->subtitle = $validated['subtitle'];
        $autismSection->description = $validated['description'];
        $autismSection->button_content = $validated['button_content'];
        $autismSection->button_link = $validated['button_link'];
        $autismSection->status = $request->status ?? "off";
        $autismSection->save();
   

        return redirect()->route('autism-screening-section')->with('success', 'Adhd details saved successfully.');
    }

    public function fetchAutismsScreeningSectionByType(Request $request)
    {
        $type = $request->type;
    
        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $autismProcess = AutismsScreening::where('type', $type)->get();
        return response()->json(['data' => $autismProcess]);
    }

    public function autismBookSection(){
        $autismBook = AutismsBook::get();
        return view('autism-section.book',compact('autismBook'));
    }

    public function saveBookSection(Request $request)
    {

        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|min:3|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_content' => 'nullable|string|max:255',
            'button_link' => 'nullable|required_with:button_content',
            'description' => 'required|string|min:100|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
        ], [
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a valid string.',
            'type.max' => 'The type must not exceed 255 characters.',
            
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
            
            'subtitle.string' => 'The subtitle must be a valid string.',
            'subtitle.max' => 'The subtitle must not exceed 255 characters.',
            
            'button_content.string' => 'The button content must be a valid string.',
            'button_content.max' => 'The button content must not exceed 255 characters.',
            
            'button_link.required_with' => 'The button link is required when button content is provided.',
            
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
            
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
        ]);
        
        // Fetch or create a new section
        $autismBook = $request->id
            ? AutismsBook::find($request->id)
            : new AutismsBook();

        // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('autism', $imageName, 'public');
            $autismBook->image = 'storage/' . $imagePath;
        }

        // Assign data
        $autismBook->type = $validated['type'];
        $autismBook->title = $validated['title'];
        $autismBook->subtitle = $validated['subtitle'];
        $autismBook->description = $validated['description'];
        $autismBook->button_content = $validated['button_content'];
        $autismBook->button_link = $validated['button_link'];
        $autismBook->status = $request->status ?? "off";
        $autismBook->save();
   

        return redirect()->route('autism-book-section')->with('success', 'Adhd details saved successfully.');
    }

    public function fetchAutismsBookSectionByType(Request $request)
    {
        $type = $request->type;
    
        // Validate the type
        if (!in_array($type, ['Child', 'Adult'])) {
            return response()->json(['error' => 'Invalid type provided.'], 400);
        }

        $autismBook = AutismsBook::where('type', $type)->get();
        return response()->json(['data' => $autismBook]);
    }

    public function autism(){
        $autismBook = AutismsBook::get();
        return view('test.autism',compact('autismBook'));
    }

    public function autismIndex(){
        $autismBook = SubCategorySection::get();
        return view('test.index',compact('autismBook'));
    }

    public function form(){
        $autismBook = AutismsBook::get();
        return view('test.form');
    }

    public function saveForm(Request $request)
    {
        // Save the CategorySection
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'second_title' => 'required|string|min:3|max:255',
            'second_subtitle' => 'nullable|string|max:255',
            'second_description' => 'nullable|string|min:100|max:2000',
            'heading' => 'nullable|string|max:1000',
            'second_sub_title.*' => 'required_with:second_sub_description.*|string|min:1|max:255',
            'second_sub_description.*' => 'nullable|string|max:255',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', // Added max size of 2MB
        ], [
            'type.required' => 'The type field is required.',
            'type.string' => 'The type must be a valid string.',
            'type.max' => 'The type must not exceed 255 characters.',
            
            'second_title.required' => 'The second title field is required.',
            'second_title.string' => 'The second title must be a valid string.',
            'second_title.min' => 'The second title must be at least 3 characters.',
            'second_title.max' => 'The second title must not exceed 255 characters.',
            
            'second_sub_title.*.required_with' => 'Each subtitle must be provided if a sub-description is given.',
            'second_sub_title.*.string' => 'Each subtitle must be a valid string.',
            'second_sub_title.*.min' => 'Each subtitle must be at least 1 character.',
            'second_sub_title.*.max' => 'Each subtitle must not exceed 255 characters.',
            
            'second_image.image' => 'The second image must be an image file.',
            'second_image.mimes' => 'The second image must be a file of type: jpeg, png, jpg, gif, webp.',
            'second_image.max' => 'The second image must not be greater than 2MB.',
            
            'second_subtitle.string' => 'The second subtitle must be a valid string.',
            'second_subtitle.max' => 'The second subtitle must not exceed 255 characters.',
            
            'second_description.string' => 'The second description must be a valid string.',
            'second_description.max' => 'The second description must not exceed 1000 characters.',
            'second_description.min' => 'The second description title must be at least 100 characters.',
            
            'heading.string' => 'The heading must be a valid string.',
            'heading.max' => 'The heading must not exceed 1000 characters.',
            
            'second_sub_description.*.nullable' => 'Each sub-description must be nullable.',
            'second_sub_description.*.string' => 'Each sub-description must be a valid string.',
            'second_sub_description.*.max' => 'Each sub-description must not exceed 255 characters.',
        ]);
        
        // Save the SubCategorySection using the newly created CategorySection ID
        $subCategorySection = SubCategorySection::create([
            'first_title' => $request->first_title,
            'type' => $request->type,
            'first_subtitle' => $request->first_subtitle ?? null,
            'first_description' => $request->first_description ?? null,
            'first_button_content' => $request->first_button_content ?? null,
            'first_button_link' => $request->first_button_link ?? null,
            'first_image' => $request->first_image ?? null,
            'second_title' => $request->second_title ?? null,
            'second_subtitle' => $request->second_subtitle ?? null,
            'second_description' => $request->second_description ?? null,
            'second_button_content' => $request->second_button_content ?? null,
            'second_button_link' => $request->second_button_link ?? null,
            'second_image' => $request->second_image ?? null,
            'pointers' => json_encode($request->pointers ?? []),
        ]);
    
        // Return a JSON response
        return redirect()->route('autism-index')->with('success', 'Adhd details saved successfully.');

    }
    
    

}
