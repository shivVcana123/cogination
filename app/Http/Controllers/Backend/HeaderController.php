<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Header;

use Illuminate\Validation\Rule;


class HeaderController extends Controller
{
    public function header(){
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        return view('header.header',compact('headerData'));
    }
    public function addheader()
    {
        return view('header.addHeader');
    }
    
    public function addOrUpdateHeader(Request $request)
    {
        // If there's an ID, find the existing header, otherwise create a new one
        $headerData = $request->has('header_id') ? Header::findOrFail($request->header_id) : new Header;

        // Validate the request
        $request->validate([
            'category' => [
                'nullable',
                'max:255',
                Rule::unique('headers', 'category')->ignore($headerData->id)
            ],
            'subcategories' => 'nullable|array', // Ensure subcategories is an array
            'subcategories.*' => 'nullable|string|max:255', // Each subcategory must be a string
            'parent_id' => 'nullable|exists:headers,id',
        ]);
    
        // Save or update the category
        $headerData->category = $request->category;
        $headerData->save();
        // Save subcategories
        if ($request->has('subcategories')) {
            foreach ($request->subcategories as $subCategory) {
                if (!empty($subCategory)) {
                    // Create new subcategory header
                    $headerData->children()->create([
                        'category' => $subCategory,
                        'parent_id' => $headerData->id, // Set the parent ID to the current header's ID
                    ]);
                }
            }
        }
        $headerData = Header::all();
        // Return to the header view, passing the header data
        return view('header.header', compact('headerData'));
    }
    
    

    public function deleteHeader($id)
    {
        $header = Header::find($id);

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


    public function fetchHeaderData()
    {
        // Fetch main sections with their subsections
        $headers = Header::with('children')->whereNull('parent_id')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => $headers,
        ], 200);
    }
}
