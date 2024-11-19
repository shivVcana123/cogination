<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderRequest;
use Illuminate\Http\Request;
use App\Models\Header;

use Illuminate\Validation\Rule;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headerData = Header::with('children')->whereNull('parent_id')->get();
        return view('header.header', compact('headerData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('header.addHeader');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeaderRequest $request)
    {
        try {
            // If there's an ID, find the existing header, otherwise create a new one
            $headerData = $request->has('header_id') ? Header::findOrFail($request->header_id) : new Header;

            // Save or update the category
            $headerData->category = $request->category;
            $headerData->link = $request->link;
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
            return redirect()->route('header.index')->with('success', 'Record created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
        }
    }


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
        $headerData = Header::with('children')->whereNull('parent_id')->where('id',$id)->get();
        return view('header.editHeader', compact('headerData'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, string $id)
     {
         try {
            $validated = $request->validate([
                'category' => 'required',
            ]);
             // Find the existing header by ID
             $headerData = Header::findOrFail($id);
     
             // Update the main category
             $headerData->update([
                 'category' => $request->category,
             ]);
     
             // Handle subcategories
             if ($request->has('subcategories')) {
                 $subcategories = $request->subcategories;
     
                 // Delete existing subcategories not in the request
                 $existingSubcategories = $headerData->children->pluck('id', 'category')->toArray();
                 $submittedCategories = collect($subcategories)->filter(); // Remove empty values
                 $toDelete = array_diff(array_keys($existingSubcategories), $submittedCategories->toArray());
                 $headerData->children()->whereIn('category', $toDelete)->delete();
     
                 // Update or create subcategories
                 foreach ($submittedCategories as $subCategory) {
                     if (!empty($subCategory)) {
                         $headerData->children()->updateOrCreate(
                             [
                                 'category' => $subCategory,
                                 'parent_id' => $headerData->id, // Ensure the parent ID matches
                             ],
                             ['category' => $subCategory]
                         );
                     }
                 }
             }
     
             return redirect()->route('header.index')->with('success', 'Record updated successfully!');
         } catch (\Exception $e) {
             // Log the error for debugging
             \Log::error('Header update failed: ' . $e->getMessage());
     
             return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
         }
     }
     
     

    // public function update(HeaderRequest $request, string $id)
    // {
    //     try {
    //         // Find the existing header by ID
    //         $headerData = Header::findOrFail($id);
    //         // Update the category and link
    //         $headerData->category = $request->category;
    //         // $headerData->link = $request->link;
    //         $headerData->save();

    //         // Update subcategories
    //         if ($request->has('subcategories')) {
    //             // Delete existing subcategories to handle complete replacement
    //             $headerData->children()->delete();

    //             foreach ($request->subcategories as $subCategory) {
    //                 if (!empty($subCategory)) {
    //                     // Create new subcategory header
    //                     $headerData->children()->create([
    //                         'category' => $subCategory,
    //                         'parent_id' => $headerData->id, // Set the parent ID to the current header's ID
    //                     ]);
    //                 }
    //             }
    //         }

    //         return redirect()->route('header.index')->with('success', 'Record updated successfully!');
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
            $header = Header::find($id);

            if (!$header) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Header not found.',
                ], 404);
            }

            $header->delete();

            return redirect()->route('header.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('header.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
