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
            dd($e->getMessage());

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
        $headerData = Header::with('children')->whereNull('parent_id')->where('id', $id)->get();
        return view('header.editHeader', compact('headerData'));
    }

    public function update(Request $request, string $id)
    {

        try {
            // Validate the request
            $validated = $request->validate([
                'category' => 'required', 
                
            ], [
                'category.required' => 'The category field is required.',
            ]);


            // Find the existing header by ID
            $headerData = Header::findOrFail($id);

            // Update the main category
            $headerData->update([
                'category' => $request->category,
                'link' => $request->link,
            ]);

            // Handle subcategories and their corresponding links
            if ($request->has('subcategories') && $request->has('subcategorieslink')) {
                $headerData->children()->delete(); // Remove old subcategories

                // Loop through subcategories and links
                foreach ($request->subcategories as $index => $subCategory) {
                    if (!empty($subCategory)) {
                        $link = $request->subcategorieslink[$index] ?? null; // Get the corresponding link

                        // Create new subcategory with the corresponding link
                        $headerData->children()->create([
                            'category' => $subCategory,
                            'link' => $link,  // Store the link along with the subcategory
                            'parent_id' => $headerData->id,
                        ]);
                    }
                }
            }

            return redirect()->route('header.index')->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
            return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());

        }
    }

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
