<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.form');
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
        $ServiceData = new News;
        // Save or update the category
        $ServiceData->title = $request->title;
        $ServiceData->description_1 = $request->description_1;
        $ServiceData->button_link = $request->link;
        $ServiceData->background_color = $request->background_color;

        if ($request->hasFile('background_image')) {
            $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $backgroundImagePath = $request->file('background_image')->storeAs('news', $backgroundImageName, 'public');
            $ServiceData->background_image = 'storage/app/public/' . $backgroundImagePath;
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('news', $imageName, 'public');
            $ServiceData->image = 'storage/app/public/' . $imagePath;
        }
        $ServiceData->save();

        return redirect()->route('news.index');
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
        $newsData = News::find($id);
        return view('news.editform',compact('newsData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
    // dd($request->all());
            $news = News::findOrFail($id);
    
            if ($request->hasFile('background_image')) {
                // Delete the old background image if it exists
                if ($news->background_image && \Storage::exists(str_replace('storage/', '', $news->background_image))) {
                    \Storage::delete(str_replace('storage/app/public/', '', $news->background_image));
                }
    
                // Store the new background image with the original file name
                $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
                $backgroundImagePath = $request->file('background_image')->storeAs('news', $backgroundImageName, 'public');
                $news->background_image ='storage/app/public/' . $backgroundImagePath;
            }
    
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($news->image && \Storage::exists(str_replace('storage/', '', $news->image))) {
                    \Storage::delete(str_replace('storage/app/public/', '', $news->image));
                }
    
                // Store the new image with the original file name
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->storeAs('news', $imageName, 'public');
                $news->image = 'storage/app/public/' . $imagePath;
            }
    
            $news->title = $request->title;
            $news->description_1 = $request->description_1;
            $news->button_link = $request->link;
            $news->background_color = $request->background_color;
    
            $news->save();
    

            return redirect()->route('news.index')->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to update record. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $news = News::findOrFail($id);

            if ($news->background_image) {
                Storage::delete('storage/app/public/' . $news->background_image);
            }

            if ($news->image) {
                Storage::delete('storage/app/public/' . $news->image);
            }

            $news->delete();

            return redirect()->route('news.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('news.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
