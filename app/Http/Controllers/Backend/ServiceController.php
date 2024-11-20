<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Header;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('Service.index',compact('services'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $headerChild = Header::with('children')->whereNull('parent_id')
        ->where('category','services')->get();
        return view('Service.form',compact('headerChild'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $ServiceData = new Service;
        // Save or update the category
        $ServiceData->title = $request->title;
        $ServiceData->description_1 = $request->description_1;
        $ServiceData->subtitle = $request->subtitle;
        $ServiceData->service_type = $request->service_type;
        $ServiceData->description_2 = $request->description_2;
        $ServiceData->pointers =json_encode($request->pointers);
        $ServiceData->button_content = $request->button_content;
        $ServiceData->button_link = $request->button_link;
        $ServiceData->background_color = $request->background_color;
        if ($request->hasFile('background_image')) {
            $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $backgroundImagePath = $request->file('background_image')->storeAs('service', $backgroundImageName, 'public');
            $ServiceData->background_image = 'storage/app/public/' . $backgroundImagePath;
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('service', $imageName, 'public');
            $ServiceData->image = 'storage/app/public/' . $imagePath;
        }
        $ServiceData->save();
       
        return redirect()->route('service.index');
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
        $services = Service::find($id);
        return view('Service.editform',compact('services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        try {
    
            $ServiceData = Service::findOrFail($id);
    
            if ($request->hasFile('background_image')) {
                // Delete the old background image if it exists
                if ($ServiceData->background_image && \Storage::exists(str_replace('storage/', '', $ServiceData->background_image))) {
                    \Storage::delete(str_replace('storage/', '', $ServiceData->background_image));
                }
    
                // Store the new background image with the original file name
                $backgroundImageName = time() . '_' . $request->file('background_image')->getClientOriginalName();
                $backgroundImagePath = $request->file('background_image')->storeAs('service', $backgroundImageName, 'public');
                $ServiceData->background_image ='storage/app/public/' . $backgroundImagePath;
            }
    
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($ServiceData->image && \Storage::exists(str_replace('storage/', '', $ServiceData->image))) {
                    \Storage::delete(str_replace('storage/', '', $ServiceData->image));
                }
    
                // Store the new image with the original file name
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')->storeAs('service', $imageName, 'public');
                $ServiceData->image = 'storage/app/public/' . $imagePath;
            }
    
            $ServiceData->title = $request->title;
            $ServiceData->subtitle = $request->subtitle;
            $ServiceData->service_type = $request->service_type;
            $ServiceData->description_1 = $request->description_1;
            $ServiceData->description_2 = $request->description_2;
            $ServiceData->button_content = $request->button_content;
            $ServiceData->button_link = $request->button_link;
            $ServiceData->background_color = $request->background_color;
            $ServiceData->pointers =json_encode($request->pointers);
    
            $ServiceData->save();
    

            return redirect()->route('service.index')->with('success', 'Record updated successfully!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to update record. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ServiceData = Service::findOrFail($id);

            if ($ServiceData->background_image) {
                Storage::delete('public/' . $ServiceData->background_image);
            }

            if ($ServiceData->image) {
                Storage::delete('public/' . $ServiceData->image);
            }

            $ServiceData->delete();

            return redirect()->route('service.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('service.index')->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
}
