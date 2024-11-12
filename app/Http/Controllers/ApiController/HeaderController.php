<?php

namespace App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Header;
use App\Models\SubCategory; // Assuming SubCategory model exists
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HeaderController extends Controller
{
    /**
     * Add or update a category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOrUpdateHeader(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'nullable|max:255|required_without:sub_title', // Require either title or sub_title
            'link' => 'nullable|unique:headers,link,' . $request->id,
            'parent_id' => 'nullable|exists:headers,id', // Check if parent_id exists in headers
            'sub_title' => 'nullable|max:255|required_without:title', // Require either sub_title or title
            'sub_link' => 'nullable|unique:headers,sub_link,' . $request->id,
        ]);

        try {
            // Determine if we're creating or updating
            $header = $request->has('id')
                ? Header::findOrFail($request->id)
                : new Header;

            // Fill and save
            $header->title = $request->title;
            $header->link = $request->link;
            $header->parent_id = $request->parent_id; // Assign parent ID for subsection
            $header->sub_title = $request->sub_title;
            $header->sub_link = $request->sub_link;
            $header->save();

            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'Header updated successfully' : 'Header created successfully',
                'data' => $header,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
