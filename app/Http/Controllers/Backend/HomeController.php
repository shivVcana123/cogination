<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeData = Home::all();
        return view('home.index',compact('homeData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required', // Ensure subcategories is an array
            'description_1' => 'required',
            'button_content' => 'required', 
            'background_color' => 'required', 
        ]);
        $ServiceData = new Home();
        // Save or update the category
        $ServiceData->title = $request->title;
        $ServiceData->description_1 = $request->description_1;
        $ServiceData->subtitle = $request->subtitle;
        // $ServiceData->pointers =json_encode($request->pointers);
        $ServiceData->button_content = $request->button_content;
        $ServiceData->button_link = $request->button_link;
        $ServiceData->background_color = $request->background_color;
        if ($request->hasFile('background_image')) {
            $backgroundImagePath = $request->file('background_image')->store('home', 'public');
            $ServiceData->background_image = $backgroundImagePath;
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('home', 'public');
            $ServiceData->image = $imagePath; 
        }
        $ServiceData->save();
       
        return redirect()->route('homes.index');
    }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming data
        $request->validate([
            'title' => 'nullable', // Optional fields
            'subtitle' => 'nullable',
            'description_1' => 'nullable',
            'button_content' => 'nullable',
            'background_color' => 'nullable',
            'background_image' => 'nullable|image', // Validate image file
            'image' => 'nullable|image', // Validate image file
        ]);
    
        // Retrieve the existing record
        $ServiceData = Home::findOrFail($id);
    
        // Update fields if present in the request
        if ($request->has('title')) {
            $ServiceData->title = $request->title;
        }
        if ($request->has('subtitle')) {
            $ServiceData->subtitle = $request->subtitle;
        }
        if ($request->has('description_1')) {
            $ServiceData->description_1 = $request->description_1;
        }
        if ($request->has('button_content')) {
            $ServiceData->button_content = $request->button_content;
        }
        if ($request->has('background_color')) {
            $ServiceData->background_color = $request->background_color;
        }
    
        // Handle file uploads if they exist
        if ($request->hasFile('background_image')) {
            // Optionally delete the old image
            if ($ServiceData->background_image) {
                \Storage::disk('public')->delete($ServiceData->background_image);
            }
            $backgroundImagePath = $request->file('background_image')->store('home', 'public');
            $ServiceData->background_image = $backgroundImagePath;
        }
    
        if ($request->hasFile('image')) {
            // Optionally delete the old image
            if ($ServiceData->image) {
                \Storage::disk('public')->delete($ServiceData->image);
            }
            $imagePath = $request->file('image')->store('home', 'public');
            $ServiceData->image = $imagePath;
        }
    
        // Save changes to the database
        $ServiceData->save();
    
        // Redirect with a success message
        return redirect()->route('homes.index')->with('success', 'Record updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
