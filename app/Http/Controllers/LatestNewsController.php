<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class LatestNewsController extends Controller
{
    public function addOrUpdateLatestNews(Request $request)
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
            $news = $request->has('id')
                ? News::findOrFail($request->id) 
                : new News;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($news->image && file_exists(public_path($news->image))) {
                    unlink(public_path($news->image));
                }
                $news->image = $fileName;
            }
            if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
                $file = $request->file('background_image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($news->background_image && file_exists(public_path($news->background_image))) {
                    unlink(public_path($news->background_image));
                }
                $news->background_image = $fileName;
            }

            // Fill the News details
            $news->title = $request->title;
            $news->subtitle = $request->subtitle;
            $news->description = $request->description;
            $news->button_content = $request->button_content;
            $news->button_link = $request->button_link;
            $news->background_color = $request->background_color;
            $news->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'News updated successfully' : 'News created successfully',
                'data' => $news,
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


    public function deleteLatestNews($id)
    {
        try {
            $news = News::findOrFail($id);
            $news->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'News deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'News not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the News.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchLatestNewsData()
    {
        // Fetch main sections with their subsections
        $news = News::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $news,
        ], 200);
    }
}
