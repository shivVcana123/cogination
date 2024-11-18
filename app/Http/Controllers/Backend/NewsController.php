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
        // $ServiceData->pointers = json_encode($request->pointers);
        $ServiceData->background_color = $request->background_color;
        if ($request->hasFile('background_image')) {
            $backgroundImagePath = $request->file('background_image')->store('news', 'public');
            $ServiceData->background_image = $backgroundImagePath;
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $ServiceData->image = $imagePath;
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
