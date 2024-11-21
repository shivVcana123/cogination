<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\PageDesign;
use App\Http\Requests\StorePageDesignRequest;
use App\Http\Requests\UpdatePageDesignRequest;
use Illuminate\Http\Request;

class PageDesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageData = PageDesign::all();
        return view('page-design.page_design',compact('pageData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(StorePageDesignRequest $request)
     {
         // Validate the request data
        //  $request->validate([
        //      'title_style' => 'required',
        //      'subtitle_style' => 'required',
        //      'description_style' => 'required',
        //      'button_content_style' => 'required',
        //      'header_color' => 'required',
        //      'footer_color' => 'required',
        //      'header_image' => 'required|image',
        //      'footer_image' => 'required|image',
        //  ]);
 
        //  dd('sdsad');
     
         // Create a new PageDesign record
         $page = new PageDesign();
     
         // Set the extracted style values
         $page->title_style = $request->input('title_style');
         $page->subtitle_style = $request->input('subtitle_style');
         $page->description_style = $request->input('description_style');
         $page->button_content_style = $request->input('button_content_style');
         $page->header_color = $request->input('header_color');
         $page->footer_color = $request->input('footer_color');
     
 
         if ($request->hasFile('header_image')) {
             $backgroundImageName = time() . '_' . $request->file('header_image')->getClientOriginalName();
             $backgroundImagePath = $request->file('header_image')->storeAs('page', $backgroundImageName, 'public');
             $page->header_image = 'storage/app/public/' . $backgroundImagePath;
         }
 
         if ($request->hasFile('footer_image')) {
             $imageName = time() . '_' . $request->file('footer_image')->getClientOriginalName();
             $imagePath = $request->file('footer_image')->storeAs('page', $imageName, 'public');
             $page->footer_image = 'storage/app/public/' . $imagePath;
         }
     
         // Save the PageDesign record to the database
         $page->save();
     
         // Redirect or return success message
         return redirect()->route('page.index')->with('success', 'Page created successfully');
     }
     

    // public function store(Request $request)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'title_style' => 'required',
    //         'subtitle_style' => 'required',
    //         'description_style' => 'required',
    //         'button_content_style' => 'required',
    //         'header_color' => 'required',
    //         'footer_color' => 'required',
    //         'header_image' => 'required|image',
    //         'footer_image' => 'required|image',
    //     ]);

    //     dd('sdsad');
    
    //     // Extract styles from the fields (if available)
    //     $titleStyle = $this->extractStyle($request->input('title_style'));
    //     $subtitleStyle = $this->extractStyle($request->input('subtitle_style'));
    //     $descriptionStyle = $this->extractStyle($request->input('description_style'));
    //     $buttonContentStyle = $this->extractStyle($request->input('button_content_style'));
    
    //     // Create a new PageDesign record
    //     $page = new PageDesign();
    
    //     // Set the extracted style values
    //     $page->title_style = $titleStyle;
    //     $page->subtitle_style = $subtitleStyle;
    //     $page->description_style = $descriptionStyle;
    //     $page->button_content_style = $buttonContentStyle;
    
    //     // Handle additional fields: header and footer colors
    //     $page->header_color = $request->input('header_color');
    //     $page->footer_color = $request->input('footer_color');
    

    //     if ($request->hasFile('header_image')) {
    //         $backgroundImageName = time() . '_' . $request->file('header_image')->getClientOriginalName();
    //         $backgroundImagePath = $request->file('header_image')->storeAs('page', $backgroundImageName, 'public');
    //         $page->header_image = 'storage/app/public/' . $backgroundImagePath;
    //     }

    //     if ($request->hasFile('footer_image')) {
    //         $imageName = time() . '_' . $request->file('footer_image')->getClientOriginalName();
    //         $imagePath = $request->file('footer_image')->storeAs('page', $imageName, 'public');
    //         $page->footer_image = 'storage/app/public/' . $imagePath;
    //     }
    
    //     // Save the PageDesign record to the database
    //     $page->save();
    
    //     // Redirect or return success message
    //     return redirect()->route('page.index')->with('success', 'Page created successfully');
    // }
    
    // // Helper function to extract style content
    // private function extractStyle($styleInput)
    // {
    //     if ($styleInput) {
    //         preg_match('/<span style="([^"]+)">/', $styleInput, $matches);
    //         return $matches[1] ?? null; // Return the style part
    //     }
    //     return null;
    // }
    
    


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
    public function edit(PageDesign $pageDesign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageDesignRequest $request, PageDesign $pageDesign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageDesign $pageDesign)
    {
        //
    }
}
