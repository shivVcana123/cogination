<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\PageDesign;
use App\Http\Requests\StorePageDesignRequest;
use App\Http\Requests\UpdatePageDesignRequest;
use Illuminate\Http\Request;
use App\Models\Header;

class PageDesignController extends Controller
{
    /**
     * Display a listing of the resource.
     
     */
    public function index()
    {
        $pageData = PageDesign::all();
        return view('page-design.index',compact('pageData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageData = new PageDesign;
        $categories = ['Title','Subtitle','Description','Header','Footer'];
        return view('page-design.page_design',compact('pageData','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
           $page = PageDesign::where('category',$request->category)->first();
		   if(!$page)
           {
         	 $page = new PageDesign();
           }
       	
         $page->category = $request->category;
         $page->font_size = $request->font_size;
         $page->font_weight = $request->font_weight;
         $page->content_color = $request->content_color;
         $page->text_alignment = $request->text_alignment;
        //  if ($request->hasFile('image') && $request->file('image')->isValid()) {
        //     $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
        //     $imagePath = $request->file('image')->storeAs('design', $imageName, 'public');
        //     $page->logo = 'storage/' . $imagePath;
        // }
         $page->save();
         return redirect()->route('page.index')->with('success', 'Page created successfully');
     }
     

   

    /**
     * Display the specified resource.
     */
    public function show(PageDesign $pageDesign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pageData = PageDesign::find($id); // Fetch the specific record
        $categories = ['Title', 'Subtitle', 'Description', 'Header', 'Footer']; // Categories list
        return view('page-design.page_design', compact('pageData', 'categories'));
    }


    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $page = PageDesign::find($id);
        $page->category = ($request->category)?$request->category:$page->category;
        $page->font_size = $request->font_size;
        $page->font_weight = $request->font_weight;
        $page->content_color = $request->content_color;
        $page->text_alignment = $request->text_alignment;
        // if ($request->hasFile('image') && $request->file('image')->isValid()) {
        //     $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
        //     $imagePath = $request->file('image')->storeAs('design', $imageName, 'public');
        //     $page->logo = 'storage/' . $imagePath;
        // }
        $page->save();
        return redirect()->route('page.index')->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        try {
            $content = PageDesign::findOrFail($id);

            if ($content->background_image) {
                Storage::delete('public/' . $content->background_image);
            }

            if ($content->image) {
                Storage::delete('public/' . $content->image);
            }

            $content->delete();

            return redirect()->route('page.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('page.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }

    public function saveDesign(Request $request)
    {
        $page = PageDesign::where('category',$request->category)->first();
      if(!$page)
      {
        $page = new PageDesign();
      }
        $page->category = ($request->category)?$request->category:$request->category;

        $page->font_size = $request->font_size;
        $page->font_weight = $request->font_weight;
        $page->content_color = $request->content_color;
        $page->text_alignment = $request->text_alignment;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('design', $imageName, 'public');
            $page->logo = 'storage/' . $imagePath;
        }

        $page->save();
        return response()->json(['message' => 'Design applied successfully!']);
  }

}
