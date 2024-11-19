<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeRequest;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeData = Home::all();
        return view('home.index', compact('homeData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HomeRequest $request)
{
    try {
        $homeData = new Home();
        $homeData->title = $request->title;
        $homeData->description_1 = $request->description_1;
        $homeData->subtitle = $request->subtitle;
        $homeData->button_content = $request->button_content;
        $homeData->button_link = $request->button_link;
        $homeData->background_color = $request->background_color;

        if ($request->hasFile('background_image')) {
            $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $backgroundImagePath = $request->file('background_image')->storeAs('home', $backgroundImageName, 'public');
            $homeData->background_image = 'storage/app/public/' . $backgroundImagePath;
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
            $homeData->image = 'storage/app/public/' . $imagePath;
        }

        $homeData->save();

        return redirect()->route('home.index')->with('success', 'Record created successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
    }
}

    // public function store(HomeRequest $request)
    // {
    //     try {
    //         $homeData = new Home();
    //         $homeData->title = $request->title;
    //         $homeData->description_1 = $request->description_1;
    //         $homeData->subtitle = $request->subtitle;
    //         $homeData->button_content = $request->button_content;
    //         $homeData->button_link = $request->button_link;
    //         $homeData->background_color = $request->background_color;

    //         if ($request->hasFile('background_image')) {
    //             $backgroundImagePath = $request->file('background_image')->store('home', 'public');
    //               $homeData->background_image = 'storage/app/public/' . $backgroundImagePath;
    //         }
    //         if ($request->hasFile('image')) {
    //             $imagePath = $request->file('image')->store('home', 'public');
    //             $homeData->image = 'storage/app/public/' . $imagePath;
    //         }

    //         $homeData->save();

    //         return redirect()->route('home.index')->with('success', 'Record created successfully!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
    //     }
    // }


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
        $homeData = Home::find($id);
        return view('home.editform', compact('homeData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HomeRequest $request, string $id)
{
    try {
        $homeData = Home::findOrFail($id);

        $homeData->title = $request->title;
        $homeData->description_1 = $request->description_1;
        $homeData->subtitle = $request->subtitle;
        $homeData->button_content = $request->button_content;
        $homeData->button_link = $request->button_link;
        $homeData->background_color = $request->background_color;

        if ($request->hasFile('background_image')) {
            // Delete the old background image if it exists
            if ($homeData->background_image && \Storage::exists(str_replace('storage/', '', $homeData->background_image))) {
                \Storage::delete(str_replace('storage/', '', $homeData->background_image));
            }

            // Store the new background image with the original file name
            $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $backgroundImagePath = $request->file('background_image')->storeAs('home', $backgroundImageName, 'public');
            $homeData->background_image = 'storage/' . $backgroundImagePath;
        }

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($homeData->image && \Storage::exists(str_replace('storage/', '', $homeData->image))) {
                \Storage::delete(str_replace('storage/', '', $homeData->image));
            }

            // Store the new image with the original file name
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('home', $imageName, 'public');
            $homeData->image = 'storage/' . $imagePath;
        }

        $homeData->save();

        return redirect()->route('home.index')->with('success', 'Record updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
    }
}

//     public function update(HomeRequest $request, string $id)
// {
//     try {
//         $homeData = Home::findOrFail($id);

//         $homeData->title = $request->title;
//         $homeData->description_1 = $request->description_1;
//         $homeData->subtitle = $request->subtitle;
//         $homeData->button_content = $request->button_content;
//         $homeData->button_link = $request->button_link;
//         $homeData->background_color = $request->background_color;

//         if ($request->hasFile('background_image')) {
//             // Delete the old background image if it exists
//             if ($homeData->background_image && \Storage::exists(str_replace('storage/app/public/', '', $homeData->background_image))) {
//                 \Storage::delete(str_replace('storage/app/public/', '', $homeData->background_image));
//             }

//             // Store the new background image
//             $backgroundImagePath = $request->file('background_image')->store('home', 'public');
//             $homeData->background_image = 'storage/app/public/' . $backgroundImagePath;
//         }

//         if ($request->hasFile('image')) {
//             // Delete the old image if it exists
//             if ($homeData->image && \Storage::exists(str_replace('storage/app/public/', '', $homeData->image))) {
//                 \Storage::delete(str_replace('storage/app/public/', '', $homeData->image));
//             }

//             // Store the new image
//             $imagePath = $request->file('image')->store('home', 'public');
//             $homeData->image = 'storage/app/public/' . $imagePath;
//         }

//         $homeData->save();

//         return redirect()->route('home.index')->with('success', 'Record updated successfully!');
//     } catch (\Exception $e) {
//         return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
//     }
// }

    // public function update(HomeRequest $request, string $id)
    // {
    //     try {
    //         $homeData = Home::findOrFail($id);

    //         if ($request->hasFile('background_image')) {
    //             if ($homeData->background_image) {
    //                 Storage::delete('public/' . $homeData->background_image);
    //             }
    //             $homeData->background_image = $request->file('background_image')->store('home', 'public');
    //         }

            
    //         if ($request->hasFile('image')) {
    //             if ($homeData->image) {
    //                 Storage::delete('public/' . $homeData->image);
    //             }
    //             $homeData->image = $request->file('image')->store('home', 'public');
    //         }

    //         $homeData->title = $request->title;
    //         $homeData->description_1 = $request->description_1;
    //         $homeData->subtitle = $request->subtitle;
    //         $homeData->button_content = $request->button_content;
    //         $homeData->button_link = $request->button_link;
    //         $homeData->background_color = $request->background_color;

    //         $homeData->save();

    //         return redirect()->route('homes.index')->with('success', 'Record updated successfully!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
    //     }
    // }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $homeData = Home::findOrFail($id);

            if ($homeData->background_image) {
                Storage::delete('public/' . $homeData->background_image);
            }

            if ($homeData->image) {
                Storage::delete('public/' . $homeData->image);
            }

            $homeData->delete();

            return redirect()->route('homes.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('homes.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
