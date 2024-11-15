<?php

namespace App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\HeaderResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Header;
use App\Models\SubCategory; // Assuming SubCategory model exists
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\select;

class HeaderController extends Controller
{
    public function header(){
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        return view('header.header',compact('headerData'));
    }
    public function addOrUpdateHeader(Request $request, $id = null)
    {
        // If $id is provided, find the existing header; otherwise, create a new one
        $header = $id ? Header::findOrFail($id) : new Header;
        $request->validate([
            'category' => [
                'nullable',
                'max:255',
                Rule::unique('headers', 'category')->ignore($header->id)
            ],
            'parent_id' => 'nullable|exists:headers,id',
        ]);
        // Set the attributes
        $header->category = $request->category;
        $header->parent_id = $request->parent_id;
        // Save the header (either create or update)
        $header->save();
        return response()->json([
            'status' => 'success',
            'message' => $id ? 'Header updated successfully' : 'Header added successfully',
            'data' => $header,
        ], 200);
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
        $headers = Header::with('children')->whereNull('parent_id')->get();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data fetched successfully',
            'data' => HeaderResource::collection($headers),
        ], 200);
    }
    
}
