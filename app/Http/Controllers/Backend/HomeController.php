<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeRequest;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeData = Home::all();
        return view('home.index', compact('homeData'));
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
    public function store(HomeRequest $request)
    {
        try {
            $homeData = new Home();
            $homeData->title = $request->title;
            $homeData->description_1 = $request->description_1;
            $homeData->subtitle = $request->subtitle;
            $homeData->button_content = $request->button_content;
            $homeData->button_link = $request->button_link;
            $homeData->background_color = $request->background_color;

            // Handle image upload
            // if ($request->hasFile('image') && $request->file('image')->isValid()) {
            //     $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            //     $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
            //     $homeData->image = 'storage/' . $imagePath;
            // }

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $originalName = $request->file('image')->getClientOriginalName();
                $cleanedName = str_replace(' ', '_', $originalName); // Replace spaces with underscores
                $imageName = uniqid() . '_' . $cleanedName;
                $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
                $homeData->image = 'storage/' . $imagePath;
            }

            $homeData->save();

            return redirect()->route('home.index')->with('success', 'Record created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $homeData = Home::findOrFail($id);
        return view('home.editform', compact('homeData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HomeRequest $request, string $id)
    {
        // dd($request->all());
        try {
            $homeData = Home::findOrFail($id);

            $homeData->title = $request->title;
            $homeData->description_1 = $request->description_1;
            $homeData->subtitle = $request->subtitle;
            $homeData->button_content = $request->button_content;
            $homeData->button_link = $request->button_link;
            $homeData->background_color = $request->background_color;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($homeData->image) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $homeData->image));
                }
                $originalName = $request->file('image')->getClientOriginalName();
                $cleanedName = preg_replace('/\s+/', '', $originalName); // Remove all whitespace
                $imageName = uniqid() . '_' . $cleanedName;
                $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
                $homeData->image = 'storage/' . $imagePath;
            }

            $homeData->save();

            return redirect()->route('home.index')->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $homeData = Home::findOrFail($id);

            // Delete images if exist
            if ($homeData->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $homeData->image));
            }

            $homeData->delete();

            return redirect()->route('home.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('home.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
