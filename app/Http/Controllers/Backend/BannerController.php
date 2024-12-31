<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BannerSection;
use Illuminate\Http\Request;
use App\Models\Header;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = BannerSection::all();
        return view('banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $headerData = Header::with('children')->where('category','!=','Home')->whereNotNull('link')->get();
        $banner = new BannerSection();
       return view('banners.form',compact('banner','headerData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:banner_sections,type,',
            ]);
        try {
            $banner = new BannerSection();
            $banner->heading = $request->heading;
            $banner->type = $request->type;
            $banner->description = $request->description;
            $banner->button_text = $request->button_text;
            $banner->button_link = $request->button_link;
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->storeAs('banner', $imageName, 'public');
                $banner->image = 'storage/app/public/' . $imagePath;
            }

            $banner->save();
            return redirect()->route('banner.index')->with('success', 'Record created successfully!');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
        }
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
        $headerData = Header::with('children')->where('category','!=','Home')->whereNotNull('link')->get();
        $banner = BannerSection::find($id);
        return view('banners.form',compact('banner','headerData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:banner_sections,type,' . $request->hidden_id,
            ]);
            $banner = BannerSection::findOrFail($request->hidden_id);
            if(!$banner)
            {
                $banner = new BannerSection();
            }
            try {
                $banner->heading = $request->heading;
                $banner->type = $request->type;
                $banner->description = $request->description;
                $banner->button_text = $request->button_text;
                $banner->button_link = $request->button_link;
                if ($request->hasFile('image')) {
                    $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                    $imagePath = $request->file('image')->storeAs('banner', $imageName, 'public');
                    $banner->image = 'storage/app/public/' . $imagePath;
                }
                $banner->save();
    
                return redirect()->route('banner.index')->with('success', 'Record created successfully!');
    
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

