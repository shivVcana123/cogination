<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function addOrUpdateServices(Request $request)
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
            $service = $request->has('id')
                ? Service::findOrFail($request->id) 
                : new Service;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($service->image && file_exists(public_path($service->image))) {
                    unlink(public_path($service->image));
                }
                $service->image = $fileName;
            }

            if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
                $file = $request->file('background_image');
                $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                if ($service->background_image && file_exists(public_path($service->background_image))) {
                    unlink(public_path($service->background_image));
                }
                $service->background_image = $fileName;
            }

            // Fill the Service details
            $service->title = $request->title;
            $service->subtitle = $request->subtitle;
            $service->description = $request->description;
            $service->button_content = $request->button_content;
            $service->button_link = $request->button_link;
            $service->background_color = $request->background_color;
            $service->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'Service updated successfully' : 'Service created successfully',
                'data' => $service,
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


    public function deleteServices($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Service deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the Service.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchServicesData()
    {
        // Fetch main sections with their subsections
        $service = Service::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $service,
        ], 200);
    }
}
