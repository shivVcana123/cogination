<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeRequest;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cta;

use App\Models\Header;

use App\Http\Resources\HeaderResource;


class CtaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cts = Cta::all();
        return view('Cta.ctaindex', compact('cts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      	$cta= new Cta();
        $links = Header::where('link','!=',null)->get();
        $headerChild = Header::with('children')->whereNull('parent_id')->where('category','Services')->get();
         $headerChild = HeaderResource::collection($headerChild);

        return view('Cta.cta',compact('cta','headerChild','links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'cta_type' => 'required',
            'title' => 'required',
            'description' => 'required', // Update to 'required' instead of 'required|string'
        ], [
            'cta_type.required' => 'The service type is required.',
            'title.required' => 'The title is required.',
            'description.required' => 'The description is required.', // Correct validation error message
        ]);
        
        $cta = new Cta();
        $cta->title = $request->title;
        $cta->cta_type = $request->cta_type;
        $cta->button_content = $request->button_content;
        $cta->button_link = $request->button_link;
        $cta->description = $request->description;
        $cta->status = $request->status ?? "off";
        $cta->save();

        return redirect()->route('cta.index')->with('success', 'Record created successfully!');
    } catch (\Exception $e) {
        // Log the exception to debug further if needed
        return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
    }
}

    // public function store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'cta_type' => 'required',
    //             'title' => 'required',
    //             'description' => 'required',
    //         ], [
    //             'cta_type.required' => 'The service type is required.',
    //             'title.required' => 'The title is required.',
    //             'description.string' => 'The description is required.',
    //         ]);
            
    //         $cta = new Cta();
    //         $cta->title = $request->title;
    //         $cta->cta_type = $request->cta_type;
    //         $cta->button_content = $request->button_content;
    //         $cta->button_link = $request->button_link;
    //         $cta->description = $request->description;
    //         $cta->status = $request->status ?? "off";
    //         $cta->save();

    //         return redirect()->route('cta.index')->with('success', 'Record created successfully!');
    //     } catch (\Exception $e) {
    //         // dd($e);
    //         return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
    //     }
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $cta= Cta::find($id);
  		$headerChild = Header::with('children')->whereNull('parent_id')->where('category','Services')->get();
       $headerChild = HeaderResource::collection($headerChild);
              $links = Header::where('link','!=','')->get();

        return view('Cta.cta',compact('cta','headerChild','links'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        try {
            $validated = $request->validate([
                'title' => 'required',
                'description' => 'required', // Update to 'required' instead of 'required|string'
            ], [
                'title.required' => 'The title is required.',
                'description.required' => 'The description is required.', // Correct validation error message
            ]);

            $cta = Cta::findOrFail($request->hidden_id);

             $cta->title = $request->title;
            $cta->cta_type = $request->cta_type;
            $cta->button_content = $request->button_content;
            $cta->button_link = $request->button_link;
            $cta->description = $request->description;
            $cta->status = $request->status ?? "off";
            
   			 $cta->save();
            return redirect()->route('cta.index')->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cta = Cta::findOrFail($id);

            // Delete images if exist
          

            $cta->delete();

            return redirect()->route('cta.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('cta.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
