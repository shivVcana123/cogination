<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AutismsBook;
use App\Models\AutismsProcess;
use App\Models\AutismsScreening;
use App\Models\AutismsSection;
use Illuminate\Http\Request;

class AutismsSectionController extends Controller
{
    public function autismSection(){
        $autismSection = AutismsSection::get();
        return view('autism-section.autismsection',compact('autismSection'));
    }

    public function saveAutismSection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string',
            'first_title' => 'required|string|max:255',
            'first_subtitle' => 'required|string|max:255',
            'first_description' => 'required|string',
            'first_button_content' => 'nullable|string|max:255',
            'first_button_link' => 'nullable|string|max:255',
            'second_title' => 'required|string|max:255',
            'second_subtitle' => 'required|string|max:255',
            'second_description' => 'required|string',
            'second_sub_title' => 'array',
            'second_sub_title.*' => 'nullable|string|max:255',
            'second_button_content' => 'nullable|string|max:255',
            'second_button_link' => 'nullable|string|max:255',
            'first_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'second_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Fetch or create a new section
        $autismSection = $request->id
            ? AutismsSection::find($request->id)
            : new AutismsSection();

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
        $autismSection->first_title = $validated['first_title'];
        $autismSection->first_subtitle = $validated['first_subtitle'];
        $autismSection->first_description = $validated['first_description'];
        $autismSection->first_button_content = $validated['first_button_content'];
        $autismSection->first_button_link = $validated['first_button_link'];
        $autismSection->second_title = $validated['second_title'];
        $autismSection->second_subtitle = $validated['second_subtitle'];
        $autismSection->second_button_content = $validated['second_button_content'];
        $autismSection->second_button_link = $validated['second_button_link'];
        $autismSection->second_description = $validated['second_description'];
        $autismSection->pointers = json_encode($pointers);

        // Handle first image upload
        if ($request->hasFile('first_image') && $request->file('first_image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('first_image')->getClientOriginalName();
            $imagePath = $request->file('first_image')->storeAs('autism', $imageName, 'public');
            $autismSection->first_image = 'storage/' . $imagePath;
        }

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

    public function autismProcessSection(){
        $autismProcess = AutismsProcess::get();
        return view('autism-section.process',compact('autismProcess'));
    }
    public function saveProcessSection(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'sub_title' => 'array',
            'sub_title.*' => 'required|string|max:255',
            'sub_description.*' => 'required|string|max:255',
            'sub_description' => 'array',
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
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'button_content' => 'required|string|max:255',
            'button_link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        // dd($request->all());
        // Validate the request data
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'button_content' => 'required|string|max:255',
            'button_link' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        return view('autism-section.autism',compact('autismBook'));
    }
}
