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
    public function store(Request $request)
{
    // Validate request data with custom error messages
    $request->validate([
        'type' => 'required|string',
        'section_type' => $request->type === 'Home' ? 'required|string' : 'nullable|string',
        'heading' => 'nullable|string',
        'subtitle' => 'nullable|string',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string',
        'button_link' => 'nullable|url',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'type.required' => 'The banner type is required.',
        'section_type.required' => 'The section banner is required when the type is Home.',
        'button_link.url' => 'The button link must be a valid URL.',
        'image.image' => 'The uploaded file must be an image.',
        'image.mimes' => 'Only JPEG, PNG, JPG, and GIF image formats are allowed.',
        'image.max' => 'The image size must not exceed 2MB.',
    ]);

    // Allow multiple banners if type is "Home"
    if ($request->type !== 'Home') {
        // Check for existing banner with the same type and section_type
        $existingBanner = BannerSection::where('type', $request->type)
            ->where('section_type', $request->section_type)
            ->first();

        // Check for existing banner with the same type (excluding Home)
        $existingBannerData = BannerSection::where('type', $request->type)->first();

        if ($existingBanner) {
            return redirect()->back()->withErrors([
                'section_type' => 'A banner with this type and section type already exists.',
            ]);
        }

        if ($existingBannerData) {
            return redirect()->back()->withErrors([
                'type' => 'A banner with this type already exists and is not Home.',
            ]);
        }
    }

    // Store new banner
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

    return redirect()->route('banner.index')->with('success', 'Banner created successfully!');
}

//     public function store(Request $request)
//     {

        
//         // Allow multiple banners if type is "Home"
// if ($request->type === 'Home') {
//     // Skip validation and allow multiple banners
// } else {
//     // Check for existing banner with the same type and section_type
//     $existingBanner = BannerSection::where('type', $request->type)
//         ->where('section_type', $request->section_type)
//         ->first();

//     // Check for existing banner with the same type (excluding Home)
//     $existingBannerData = BannerSection::where('type', $request->type)
//         ->first();

//     if ($existingBanner) {
//         return redirect()->back()->withErrors([
//             'section_type' => 'A banner with this type and section type already exists.',
//         ]);
//     }

//     if ($existingBannerData) {
//         return redirect()->back()->withErrors([
//             'type' => 'A banner with this type already exists and is not Home.',
//         ]);
//     }
// }

// dd('sdsadsa');
//         $banner = new BannerSection();
//         $banner->heading = $request->heading;
//         $banner->subtitle = $request->subtitle;
//         $banner->type = $request->type;
//         $banner->section_type = $request->section_type ?? '';
//         $banner->description = $request->description;
//         $banner->button_text = $request->button_text;
//         $banner->button_link = $request->button_link;
//         if ($request->hasFile('image') && $request->file('image')->isValid()) {
//             $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
//             $imagePath = $request->file('image')->storeAs('banner', $imageName, 'public');
//             $banner->image = 'storage/' . $imagePath;
//         }

//         $banner->save();
//         return redirect()->route('banner.index')->with('success', 'Record created successfully!');
//     }

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
