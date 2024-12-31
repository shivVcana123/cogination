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
            $cta = new Cta();
            $cta->title = $request->title;
            $cta->cta_type = $request->cta_type;
            $cta->button_content = $request->button_content;
            $cta->button_link = $request->button_link;
			$cta->type = $request->type;

            if($cta->type == 'image')
            {
                $cta->background_color = '';
    
                if ($request->hasFile('background_image')) {
                    $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
                    $backgroundImagePath = $request->file('background_image')->storeAs('news', $backgroundImageName, 'public');
                    $cta->background_image = 'storage/app/public/' . $backgroundImagePath;
                }
            }else{
                $cta->background_color = $request->background_color;
                $cta->background_image = '';
            }
    
            
            $cta->save();

            return redirect()->route('cta.index')->with('success', 'Record created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create record: ' . $e->getMessage());
        }
    }

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
        try {
            $cta = Cta::findOrFail($request->hidden_id);

             $cta->title = $request->title;
            $cta->cta_type = $request->cta_type;
            $cta->button_content = $request->button_content;
            $cta->button_link = $request->button_link;
			$cta->type = $request->type;

            if($cta->type == 'image')
            {
                $cta->background_color = '';
    
                if ($request->hasFile('background_image')) {
                    $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
                    $backgroundImagePath = $request->file('background_image')->storeAs('news', $backgroundImageName, 'public');
                    $cta->background_image = 'storage/app/public/' . $backgroundImagePath;
                }
            }else{
                $cta->background_color = $request->background_color;
                $cta->background_image = '';
           }
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
