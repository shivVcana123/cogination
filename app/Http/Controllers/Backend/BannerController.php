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

        $existingBanner = BannerSection::where('type', $request->type)
            ->where('section_type', $request->section_type)
            ->first();

        if ($existingBanner) {
            // dd('Existing banner found!'); // Debugging point
            return redirect()->back()->withErrors([
                'section_type' => 'A banner with this type and section type already exists.',
            ]);
        }

        $banner = new BannerSection();
        $banner->heading = $request->heading;
        $banner->subtitle = $request->subtitle;
        $banner->type = $request->type;
        $banner->section_type = $request->section_type ?? '';
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

        $request->validate([
            'heading' => 'required',
            'description' => 'required',
        ], [
            'heading.required' => 'The heading field is required.',
            'image.image' => 'The uploaded file must be an image.',
        ]);
        $banner = BannerSection::findOrFail($request->hidden_id);
        if (!$banner) {
            $banner = new BannerSection();
        }

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
