<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UsefulLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsefullLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usefulllinks = UsefulLink::all();
        return view('usefull-link.index', compact('usefulllinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usefull-link.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate(
        [
            'title' => 'required|string|max:255',
            'url_content' => 'required|array',
            'url_content.*' => 'required|string', // Ensures each item in url_content is a string and not empty
            'url_link' => 'required|array',
            'url_link.*' => 'required', // Ensures each item in url_link is a valid URL
            'background_color' => 'nullable|string|max:7',
            'image' => 'nullable|image|max:2048', // Adjust size limit as needed
            'background_image' => 'nullable|image|max:2048',
        ],
        [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title must not exceed 255 characters.',
            'url_content.required' => 'The URL content field is required.',
            'url_content.array' => 'The URL content must be an array.',
            'url_content.*.required' => 'Each URL content is required.',
            'url_content.*.string' => 'Each URL content must be a valid string.',
            'url_link.required' => 'The URL link field is required.',
            'url_link.array' => 'The URL link must be an array.',
            'url_link.*.required' => 'Each URL link is required.',
            'background_color.string' => 'The background color must be a valid string.',
            'background_color.max' => 'The background color must not exceed 7 characters.',
            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'The image size must not exceed 2MB.',
            'background_image.image' => 'The background image must be a valid image file.',
            'background_image.max' => 'The background image size must not exceed 2MB.',
        ]
    );
    
    

    // Combine `url_content` and `url_link` into JSON
    $pointers = [];
    foreach ($request->url_content as $index => $content) {
        $pointers[] = [
            'content' => $content,
            'link' => $request->url_link[$index] ?? null,
        ];
    }

    // Create a new instance of the model
    $ServiceData = new UsefulLink();

    // Assign individual fields
    $ServiceData->title = $request->title;
    $ServiceData->pointers = json_encode($pointers);
    $ServiceData->background_color = $request->background_color;

    // Handle file uploads
    if ($request->hasFile('background_image')) {
        $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
        $backgroundImagePath = $request->file('background_image')->storeAs('link', $backgroundImageName, 'public');
        $ServiceData->background_image = 'storage/app/public/' . $backgroundImagePath;
    }

    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $imagePath = $request->file('image')->storeAs('link', $imageName, 'public');
        $ServiceData->image = 'storage/app/public/' . $imagePath;
    }

    // Save the record
    $ServiceData->save();

    return redirect()->route('link.index');
}
    // public function store(Request $request)
    // {
    //     dd($request->all());
    //     $request->validate([
    //         'title' => 'required',
    //     ]);
    //     $ServiceData = new UsefulLink;
    //     // Save or update the category
    //     $ServiceData->title = $request->title;
    //     $ServiceData->background_color = $request->background_color;
    //     $ServiceData->pointers = json_encode($request->pointers);
    //     if ($request->hasFile('background_image')) {
    //         $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
    //         $backgroundImagePath = $request->file('background_image')->storeAs('link', $backgroundImageName, 'public');
    //         $ServiceData->background_image = 'storage/app/public/' . $backgroundImagePath;
    //     }

    //     if ($request->hasFile('image')) {
    //         $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
    //         $imagePath = $request->file('image')->storeAs('link', $imageName, 'public');
    //         $ServiceData->image = 'storage/app/public/' . $imagePath;
    //     }
    //     $ServiceData->save();

    //     return redirect()->route('link.index');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $linkData = UsefulLink::find($id);
        return view('usefull-link.editform',compact('linkData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
 
        // Retrieve the existing record
        $ServiceData = UsefulLink::findOrFail($id);
    
        // Combine `url_content` and `url_link` into JSON
        $pointers = [];
        foreach ($request->url_content as $index => $content) {
            $pointers[] = [
                'content' => $content,
                'link' => $request->url_link[$index] ?? null,
            ];
        }
    
        // Update individual fields
        $ServiceData->title = $request->title;
        $ServiceData->pointers = json_encode($pointers);
        $ServiceData->background_color = $request->background_color;
    
        if ($request->hasFile('background_image')) {
            // Delete the old background image if it exists
            if ($ServiceData->background_image && \Storage::exists(str_replace('storage/app/public/', '', $ServiceData->background_image))) {
                \Storage::delete(str_replace('storage/app/public/', '', $ServiceData->background_image));
            }

            // Store the new background image with the original file name
            $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $backgroundImagePath = $request->file('background_image')->storeAs('link', $backgroundImageName, 'public');
            $ServiceData->background_image ='storage/app/public/' . $backgroundImagePath;
        }

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($ServiceData->image && \Storage::exists(str_replace('storage/app/public/', '', $ServiceData->image))) {
                \Storage::delete(str_replace('storage/app/public/', '', $ServiceData->image));
            }

            // Store the new image with the original file name
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('link', $imageName, 'public');
            $ServiceData->image = 'storage/app/public/' . $imagePath;
        }
        // Save the updated record
        $ServiceData->save();
    
        return redirect()->route('link.index')->with('success', 'Link updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $linkData = UsefulLink::findOrFail($id);

            if ($linkData->background_image) {
                Storage::delete('storage/app/public/' . $linkData->background_image);
            }

            if ($linkData->image) {
                Storage::delete('storage/app/public/' . $linkData->image);
            }

            $linkData->delete();

            return redirect()->route('link.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('link.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
