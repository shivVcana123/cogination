<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBannerRequest;
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
        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $headerData = Header::with('children')->whereNotNull('link')->get();
        $banner = new BannerSection();
        return view('banners.form', compact('banner', 'headerData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddBannerRequest $request)
    {
        // $request->validate([
        //     'type' => 'required|unique:banner_sections,type,',
        //     ]);

        dd($request->all());
        // $request->validate([
        //     'type' => 'required|string|max:255',
        //     'heading' => 'required|string|max:255',
        //     'subtitle' => 'nullable|string|max:255',
        //     'description' => 'required',
        //     'button_text' => 'nullable|string|max:255',
        //     'button_link' => 'nullable|url|max:255',
        //     'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,svg', // Max size 2MB
        // ], [
        //     'type.required' => 'The banner type is required.',
        //     'type.string' => 'The banner type must be a valid string.',
        //     'type.max' => 'The banner type must not exceed 255 characters.',
        //     'heading.required' => 'The heading is required.',
        //     'heading.string' => 'The heading must be a valid string.',
        //     'heading.max' => 'The heading must not exceed 255 characters.',
        //     'subtitle.string' => 'The subtitle must be a valid string.',
        //     'subtitle.max' => 'The subtitle must not exceed 255 characters.',
        //     'description.required' => 'The description is required.',
        //     'description.string' => 'The description must be a valid string.',
        //     'button_text.string' => 'The button text must be a valid string.',
        //     'button_text.max' => 'The button text must not exceed 255 characters.',
        //     'button_link.url' => 'The button link must be a valid URL.',
        //     'button_link.max' => 'The button link must not exceed 255 characters.',
        //     'image.required' => 'An image is required.',
        //     'image.image' => 'The uploaded file must be an image.',
        //     'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif, webp, svg.',
         
        // ]);
        

   
            $banner = new BannerSection();
            $banner->heading = $request->heading;
            $banner->subtitle = $request->subtitle;
            $banner->type = $request->type;
            $banner->section_type = $request->section_type;
            $banner->section_type = $request->section_banner;
            $banner->description = $request->description;
            $banner->button_text = $request->button_text;
            $banner->button_link = $request->button_link;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->storeAs('banner', $imageName, 'public');
                $banner->image = 'storage/' . $imagePath;
            }

            $banner->save();
            return redirect()->route('banner.index')->with('success', 'Record created successfully!');
        
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
        $headerData = Header::with('children')->whereNotNull('link')->get();
        $banner = BannerSection::find($id);
        return view('banners.form', compact('banner', 'headerData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'type' => 'required|unique:banner_sections,type,' . $request->hidden_id,
        //     ]);
        $request->validate([
            'heading' => 'required',
        ]);
        $banner = BannerSection::findOrFail($request->hidden_id);
        if (!$banner) {
            $banner = new BannerSection();
        }
        try {
            $banner->heading = $request->heading;
            $banner->subtitle = $request->subtitle;
            $banner->type = $request->type;
            $banner->section_type = $request->section_type;
            $banner->section_type = $request->section_banner;
            $banner->description = $request->description;
            $banner->button_text = $request->button_text;
            $banner->button_link = $request->button_link;
            // if ($request->hasFile('image')) {
            //     $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            //     $imagePath = $request->file('image')->storeAs('banner', $imageName, 'public');
            //     $banner->image = 'storage/app/public/' . $imagePath;
            // }
            // Handle first image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->storeAs('banner', $imageName, 'public');
                $banner->image = 'storage/' . $imagePath;
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
        $banner = BannerSection::findOrFail($id);
        $banner->delete();
        return redirect()->back()->with('success', 'Record deleted successfully.');

    }
}
