<?php

namespace App\Http\Controllers;

use App\Models\UsefulLink;
use Illuminate\Http\Request;

class UsefullLinlsController extends Controller
{
    public function addOrUpdateUsefullLinls(Request $request)
    {
        // Debugging request data
        //dd($request->all());

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
            $usefulLink = $request->has('id')
                ? UsefulLink::findOrFail($request->id) 
                : new UsefulLink;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($usefulLink->image && file_exists(public_path($usefulLink->image))) {
                    unlink(public_path($usefulLink->image));
                }
                $usefulLink->image = $fileName;
            }

            if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
                $file = $request->file('background_image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($usefulLink->background_image && file_exists(public_path($usefulLink->background_image))) {
                    unlink(public_path($usefulLink->background_image));
                }
                $usefulLink->background_image = $fileName;
            }

            // Fill the UsefulLink details
            $usefulLink->title = $request->title;
            $usefulLink->subtitle = $request->subtitle;
            $usefulLink->description = $request->description;
            $usefulLink->button_content = $request->button_content;
            $usefulLink->button_link = $request->button_link;
            $usefulLink->background_color = $request->background_color;
            $usefulLink->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'UsefulLink updated successfully' : 'UsefulLink created successfully',
                'data' => $usefulLink,
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


    public function deleteUsefullLinls($id)
    {
        try {
            $usefulLink = UsefulLink::findOrFail($id);
            $usefulLink->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'UsefulLink deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'UsefulLink not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the UsefulLink.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchUsefullLinlsData()
    {
        // Fetch main sections with their subsections
        $usefulLink = UsefulLink::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $usefulLink,
        ], 200);
    }
}
