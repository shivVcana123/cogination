<?php

namespace App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $homeData = Home::get();
        return view('home.home',compact('homeData'));
    }
    public function addOrUpdateHome(Request $request)
    {
        // Debugging request data
        // dd($request->all());

        // Validate the request data
        // $validated = $request->validate([
        //     'title' => 'nullable|max:255',
        //     'subtitle' => 'nullable|max:255',
        //     'description' => 'nullable|max:255',
        //     'button_content' => 'nullable|max:255',
        //     'button_link' => 'nullable|url',
        //     'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',  // Validate image file type and size
        //     'background_color' => 'nullable|string',
        // ]);

        try {
            // Check if we're updating or creating
            // $home = $request->has('id')
            //     ? Home::findOrFail($request->id) 
            //     : new Home;

            // if ($request->hasFile('image') && $request->file('image')->isValid()) {
            //     $file = $request->file('image');
            //     $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('uploads'), $fileName);
            //     if ($home->image && file_exists(public_path($home->image))) {
            //         unlink(public_path($home->image));
            //     }
            //     $home->image = $fileName;
            // }
            // if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
            //     $file = $request->file('background_image');
            //     $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('uploads'), $fileName);
            //     if ($home->background_image && file_exists(public_path($home->background_image))) {
            //         unlink(public_path($home->background_image));
            //     }
            //     $home->background_image = $fileName;
            // }


            // // Fill the home details
            // $home->title = $request->title;
            // $home->subtitle = $request->subtitle;
            // $home->description = $request->description;
            // $home->button_content = $request->button_content;
            // $home->button_link = $request->button_link;
            // $home->background_color = $request->background_color;
            // $home->save();
            dd( 'sdsadsa');
            $request->validate([
                'title' => 'required',
                'subtitle' => 'required', // Ensure subcategories is an array
                'description_1' => 'required',
                'button_content' => 'required', 
                'background_color' => 'required', 
            ]);
            $ServiceData = new Home();
            // Save or update the category
            $ServiceData->title = $request->title;
            $ServiceData->description_1 = $request->description_1;
            $ServiceData->subtitle = $request->subtitle;
            // $ServiceData->pointers =json_encode($request->pointers);
            $ServiceData->button_content = $request->button_content;
            $ServiceData->button_link = $request->button_link;
            $ServiceData->background_color = $request->background_color;
            if ($request->hasFile('background_image')) {
                $backgroundImagePath = $request->file('background_image')->store('home', 'public');
                $ServiceData->background_image = $backgroundImagePath;
            }
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('home', 'public');
                $ServiceData->image = $imagePath; 
            }
            dd( $ServiceData);
            $ServiceData->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'Home updated successfully' : 'Home created successfully',
                'data' => $ServiceData,
            ], 200);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function deleteHome($id)
    {
        try {
            $home = Home::findOrFail($id);
            $home->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Home deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Home not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the home.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchHomeData()
    {
        // Fetch main sections with their subsections
        $home = Home::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $home,
        ], 200);
    }
}
