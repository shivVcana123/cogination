<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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
    public function addOrUpdateCategory(Request $request)
    {
        // Validate the request data for category
        $validated = $request->validate([
            'title' => 'required|unique:categories|max:255', // Unique for categories table
        ]);

        try {
            // Determine if we're creating or updating
            $category = $request->has('id') 
                ? Category::findOrFail($request->id) 
                : new Category;

            // Fill and save
            $category->title = $request->title;
            $category->url = $request->url;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'Category updated successfully' : 'Category created successfully',
                'data' => $category,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryDelete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
        ], 200);
    }

    /**
     * Add or update a subcategory.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOrUpdateSubCategory(Request $request)
    {
        // dd($request->all());
        // Validate the request data for subcategory
        $validated = $request->validate([
            'title' => 'required|max:255', 
            'category_id' => 'required',  
        ]);

        try {
            // Determine if we're creating or updating
            $subCategory = $request->has('id') 
                ? SubCategory::findOrFail($request->id) 
                : new SubCategory;

            // Fill and save
            $subCategory->title = $request->title;
            $subCategory->url = $request->url;
            $subCategory->categories_id  = $request->category_id;
            $subCategory->save();

            return response()->json([
                'status' => 'success',
                'message' => $request->has('id') ? 'Subcategory updated successfully' : 'Subcategory created successfully',
                'data' => $subCategory,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a subcategory.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function subCategoryDelete($id)
    {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subcategory not found.',
            ], 404);
        }

        $subCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Subcategory deleted successfully',
        ], 200);
    }


    public function fetchCategoryData(){
        $category = Category::with('subCategory')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'fetch data successfully',
            'data' => $category,
        ], 200);
    }
}
