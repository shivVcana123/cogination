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
    public function create()
    {
       $footer =  new Footer();
       $headers = Header::all();
       return view('Footer.form',compact('footer','headers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $footer = new Footer;
        $footer->title = $request->title;
        $footer->address = $request->address;
        $footer->description = $request->description;
        $footer->phone_no = $request->phone_no;
        $footer->email = $request->email;
        $footer->background_color = $request->background_color;
        $footer->display_data = json_encode($request->dats_display);
        $footer->link = json_encode($request->links);
        if ($request->hasFile('background_image')) {
            $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $backgroundImagePath = $request->file('background_image')->storeAs('service', $backgroundImageName, 'public');
            $footer->background_image = 'storage/app/public/' . $backgroundImagePath;
        }
        $footer->save();
        return redirect()->route('footer.index');
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
        //
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
