<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TitleRequest;
use App\Models\OurApproach;
use App\Models\OurApproachHowItWork;
use Illuminate\Http\Request;

class OurApproachController extends Controller
{

    public function ourApproachSection()
    {
        $ourApproachSection = OurApproach::all();
        return view('our-approach-section.ourapproach', compact('ourApproachSection'));
    }

    public function saveOurApproachSection(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required', // Increased limit for better flexibility
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Added max file size 2MB
        ], [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif,svg, webp.',
        ]);

        // Fetch or create a new section
        $autismSection = $request->id
            ? OurApproach::find($request->id)
            : new OurApproach();



        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $autismSection->image = 'storage/' . $imagePath;
        }

        // Assign data to the model
        $autismSection->title = $request->title;
        $autismSection->description = $request->description;
        $autismSection->status = $request->status ?? "off";
        $autismSection->page = 'Our Approach';
        $autismSection->url = 'our-approach';
        // Save the model
        $autismSection->save();

        // Redirect with success message
        return redirect()->route('our-approach-section')
            ->with('success', 'Adhd details saved successfully.');
    }

    public function howItWorksSection()
    {
        $howItWorkSection = OurApproachHowItWork::all();
        return view('our-approach-section.howitworks', compact('howItWorkSection'));
    }

    public function savehowItWorksSection(Request $request)
    {
            $validated = $request->validate([
                'title' => 'required',
                'sub_title' => 'nullable|array',
                'sub_title.*' => 'required|string|max:255', // Ensures each subtitle is required
                'sub_description' => 'nullable|array',
                'sub_description.*' => 'required|string|max:255', // Each sub-description can be null but must be a string
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg', // Added max file size 2MB
            ], [
                'title' => 'The title field is required.',
                'sub_title.required' => 'Each subtitle is required.',
                'sub_title.array' => 'The subtitles must be an array.',
                'sub_title.*.required' => 'Each subtitle is required and must be a string.',
                'sub_title.*.string' => 'Each subtitle must be a valid string.',
                'sub_description.array' => 'The sub-descriptions must be an array.',
                'sub_description.*.string' => 'Each sub-description must be a valid string.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif,svg, webp.',
            ]);
            // Fetch or create a new section
            $autismSection = $request->id
                ? OurApproachHowItWork::find($request->id)
                : new OurApproachHowItWork();

            // Prepare pointers
            $pointers = [];
            if (!empty($request->input('sub_title'))) {
                foreach ($request->input('sub_title') as $index => $subTitle) {
                    $pointers[] = [
                        'sub_title' => $subTitle,
                        'sub_description' => $request->input('sub_description')[$index] ?? null,
                    ];
                }
            }

           // Handle first image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time().'_'.uniqid().'_'.$request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('about', $imageName, 'public');
            $autismSection->image = 'storage/'.$imagePath;
        }

            // Assign data to the model
            $autismSection->title = $request->title;
            $autismSection->status = $request->status ?? "off";
            $autismSection->page = 'Our Approach';
            $autismSection->url = 'our-approach';
            $autismSection->pointers = json_encode($pointers);

            // Save the model
            $autismSection->save();

            // Redirect with success message
            return redirect()->route('how-it-works-section')
                ->with('success', 'Details saved successfully.');
        
    }
}
