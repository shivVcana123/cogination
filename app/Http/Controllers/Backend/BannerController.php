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
        'type' => 'required|string|min:3|max:50',
        'section_type' => $request->type === 'Home' ? 'nullable' : 'required|string|min:3|max:50',
        'heading' => 'required|string|min:3|max:255',
        'subtitle' => 'nullable|string|min:3|max:255',
        'description' => 'required|string|min:10|max:2000',
        'button_text' => 'nullable|string|min:3|max:100',
        'button_link' => 'nullable|max:500',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
    ], [
        'type.required' => 'The banner type is required.',
        'type.min' => 'The banner type must be at least 3 characters.',
        'type.max' => 'The banner type must not exceed 50 characters.',
        'section_type.required' => 'A banner with this type and section type already exists.',
        'section_type.min' => 'The section type must be at least 3 characters.',
        'section_type.max' => 'The section type must not exceed 50 characters.',
        'heading.required' => 'The heading is required.',
        'heading.min' => 'The heading must be at least 3 characters.',
        'heading.max' => 'The heading must not exceed 255 characters.',
        'subtitle.min' => 'The subtitle must be at least 3 characters.',
        'subtitle.max' => 'The subtitle must not exceed 255 characters.',
        'description.required' => 'The description is required.',
        'description.min' => 'The description must be at least 10 characters.',
        'description.max' => 'The description must not exceed 2000 characters.',
        'button_text.min' => 'The button text must be at least 3 characters.',
        'button_text.max' => 'The button text must not exceed 100 characters.',
        'button_link.max' => 'The button link must not exceed 500 characters.',
        'image.image' => 'The uploaded file must be an image.',
        'image.mimes' => 'Only jpeg, png, jpg, gif, webp, and svg image formats are allowed.',
    ]);
    

    // Allow multiple banners if type is "Home"
     if ($request->type !== 'Home') {
    //     // Check for existing banner with the same type and section_type
         $existingBanner = BannerSection::where('type', $request->type)
             ->where('section_type', $request->section_type)
             ->first();
     



    //     // Check for existing banner with the same type (excluding Home)
    //     $existingBannerData = BannerSection::where('type', $request->type)->first();

         if ($existingBanner) {
            return redirect()->back()->withErrors([
                 'section_type' => 'A banner with this type and section type already exists.',
             ]);
         }

    //     if ($existingBannerData) {
    //         return redirect()->back()->withErrors([
    //             'type' => 'A banner with this type already exists and is not Home.',
    //         ]);
    //     }
     }

    // Store new banner
    $banner = new BannerSection();
    $banner->heading = $request->heading;
    $banner->subtitle = $request->subtitle;
    $banner->type = $request->type;
    switch ($request->type) {
        case 'Home':
            $url_type = 'Home';
            break;
        case 'ADHD':
            $url_type = 'ADHD';
            break;
        case 'Autism':
            $url_type = 'Autism';
            break;
        case 'Assessment':
            $url_type = 'Assessment';
            break;
        case 'Fees':
            $url_type = 'Fees';
            break;
        case 'About Us':
            $url_type = 'About Us';
            break;
        case 'Our Approach':
            $url_type = 'Our Approach';
            break;
        case 'Accreditation & Certifications':
            $url_type = 'Accreditation & Certifications';
            break;

        default:
            $url_type = null;
            break;
    }
    $banner->url = $url_type;
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
        switch ($request->type) {
            case 'Home':
                $url_type = 'Home';
                break;
            case 'ADHD':
                $url_type = 'ADHD';
                break;
            case 'Autism':
                $url_type = 'Autism';
                break;
            case 'Assessment':
                $url_type = 'Assessment';
                break;
            case 'Fees':
                $url_type = 'Fees';
                break;
            case 'About Us':
                $url_type = 'About Us';
                break;
            case 'Our Approach':
                $url_type = 'Our Approach';
                break;
            case 'Accreditation & Certifications':
                $url_type = 'Accreditation & Certifications';
                break;
    
            default:
                $url_type = null;
                break;
        }
        $banner->url = $url_type;
        $banner->section_type = $request->section_type ?? '';
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
