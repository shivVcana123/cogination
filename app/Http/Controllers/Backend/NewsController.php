<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

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
            'background_color' => 'required',
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
