<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutUs = AboutUs::all();
        return view('about.index', compact('aboutUs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('about.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description_1' => 'required',
        ]);
        $ServiceData = new AboutUs;
        // Save or update the category
        $ServiceData->title = $request->title;
        $ServiceData->description_1 = $request->description_1;
        $ServiceData->description_2 = $request->description_2;
        // $ServiceData->pointers = json_encode($request->pointers);
        $ServiceData->button_content = $request->button_content;
        $ServiceData->button_link = $request->button_link;
        $ServiceData->background_color = $request->background_color;
        if ($request->hasFile('background_image')) {
            $backgroundImagePath = $request->file('background_image')->store('about', 'public');
            $ServiceData->background_image = $backgroundImagePath;
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('about', 'public');
            $ServiceData->image = $imagePath;
        }
        $ServiceData->save();

        return redirect()->route('abouts.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
