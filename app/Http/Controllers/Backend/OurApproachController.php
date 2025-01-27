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

    public function saveOurApproachSection(TitleRequest $request)
    {
        // dd($request->all());
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

    public function savehowItWorksSection(TitleRequest $request)
    {
        // Debugging (optional)
        // dd($request->all());
        try {
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
            $autismSection->pointers = json_encode($pointers);

            // Save the model
            $autismSection->save();

            // Redirect with success message
            return redirect()->route('how-it-works-section')
                ->with('success', 'Details saved successfully.');
        } catch (\Exception $e) {
            dd($e);
            //throw $th;
        }
    }
}
