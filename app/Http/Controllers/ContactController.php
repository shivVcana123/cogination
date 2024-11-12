<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Matcher\Contains;

class ContactController extends Controller
{
    public function addOrUpdateContact(Request $request)
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
                ? Contact::findOrFail($request->id)
                : new Contact;

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

    public function deleteContact($id)
    {
        $header = Contact::find($id);

        if (!$header) {
            return response()->json([
                'status' => 'error',
                'message' => 'Header not found.',
            ], 404);
        }

        $header->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Header deleted successfully',
        ], 200);
    }


    public function fetchContactData()
    {
        // Fetch main sections with their subsections
        $headers = Contact::with('children')->whereNull('parent_id')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $headers,
        ], 200);
    }

    public function addContact(Request $request)
    {
        // Create a new user
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        // Return success response
        return response()->json([
            'status' => 'success',
            'data' => $contact,
            'message' => 'Contact added successfully',
        ], 200);
    }
}
