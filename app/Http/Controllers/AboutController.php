<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function addOrUpdateAbout(Request $request)
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
            $about = $request->has('id')
                ? AboutUs::findOrFail($request->id) 
                : new AboutUs;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($about->image && file_exists(public_path($about->image))) {
                    unlink(public_path($about->image));
                }
                $about->image = $fileName;
            }
            if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
                $file = $request->file('background_image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($about->background_image && file_exists(public_path($about->background_image))) {
                    unlink(public_path($about->background_image));
                }
                $about->background_image = $fileName;
            }

            // Fill the about details
            $about->title = $request->title;
            $about->subtitle = $request->subtitle;
            $about->description = $request->description;
            $about->button_content = $request->button_content;
            $about->button_link = $request->button_link;
            $about->background_color = $request->background_color;
            $about->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'about updated successfully' : 'about created successfully',
                'data' => $about,
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


    public function deleteAbout($id)
    {
        try {
            $about = AboutUs::findOrFail($id);
            $about->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'about deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'about not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the about.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchAboutData()
    {
        // Fetch main sections with their subsections
        $about = AboutUs::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $about,
        ], 200);
    }
}
