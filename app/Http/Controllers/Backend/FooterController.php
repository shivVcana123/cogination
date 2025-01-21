<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\Header;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footerData = Footer::all();
        return view('Footer.index',compact('footerData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function footer()
    {
       $footerData = Footer::get();
       $headers = Header::where('link', '!=', '')->get();
    //    dd($headers);
       return view('Footer.form',compact('footerData','headers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveFooter(Request $request)
    {
        // dd($request->all());
        $linkPointers = [];
        if ($request->has('dats_display')) {
            foreach ($request->dats_display as $index => $nameData) {
                $linkPointers[] = [
                    'name' => $index, // Key of the associative array (e.g., "Home", "ADHD")
                    'link' => $nameData, // Value of the associative array (e.g., "/", "adhd")
                ];
            }
        }
    
        $footer = $request->id ? Footer::find($request->id) : new Footer;
        $footer->title1 = $request->title1;
        $footer->title2 = $request->title2;
        $footer->address = $request->address;
        $footer->description = $request->description;
        $footer->phone_no = $request->phone_no;
        $footer->email = $request->email;
        $footer->start_time = $request->start_time;
        $footer->display_data = json_encode($linkPointers);
        // $footer->link = json_encode($linkPointers);
        $footer->end_time = $request->end_time;
        $footer->days = $request->days;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('logo', $imageName, 'public');
            $footer->image = 'storage/' . $imagePath;
        }
        $footer->save();
        return redirect()->route('footer');
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
       
        $footer =  new Footer();
       $headers = Header::all();
       $footer = Footer::find($id);
       
       return view('Footer.form',compact('footer','headers','footer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
