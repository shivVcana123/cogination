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
        $cta = new Cta();
        $links = Header::where('link', '!=', null)->get();
        $headerChild = Header::with('children')->whereNull('parent_id')->where('category', 'Services')->get();
        $headerChild = HeaderResource::collection($headerChild);

        return view('Cta.cta', compact('cta', 'headerChild', 'links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'cta_type' => 'required',
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:100|max:2000',
            'button_content' => 'nullable|string|max:255',
            'button_link' => 'nullable|required_with:button_content',
        ], [
            'cta_type.required' => 'Please select the page .',
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
        ]);

        $existingCta = Cta::where('cta_type', $request->cta_type)->first();

        if ($existingCta) {
            return redirect()->back()
                ->withErrors(['cta_type' => 'This cta section already exists.'])
                ->withInput(); // <-- This ensures old input is kept
        }


        $cta = new Cta();
        $cta->title = $request->title;
        $cta->cta_type = $request->cta_type;
        switch ($request->type) {
            case 'Home':
                $url_type = '/';
                $url_page = $request->type;
                break;
            case 'ADHD':
                $url_type = 'adhd';
                $url_page = $request->type;
                break;
            case 'Autism':
                $url_type = 'autism';
                $url_page = $request->type;
                break;
            case 'Assessment':
                $url_type = 'assessment';
                $url_page = $request->type;
                break;
            case 'Fees':
                $url_type = 'fee';
                $url_page = $request->type;
                break;
            case 'About Us':
                $url_type = 'about';
                $url_page = $request->type;
                break;
            case 'Our Approach':
                $url_type = 'our-approach';
                $url_page = $request->type;
                break;
            case 'Accreditation & Certifications':
                $url_type = 'accreditation';
                $url_page = $request->type;
                break;
    
            default:
                $url_type = null;
                $url_page = null;
                break;
        }
        $cta->page = $url_page;
        $cta->url = $url_type;
        $cta->button_content = $request->button_content;
        $cta->button_link = $request->button_link;
        $cta->description = $request->description;
        $cta->status = $request->status ?? "off";
        $cta->save();

        return redirect()->route('cta.index')->with('success', 'Record created successfully!');
    }

    public function edit(string $id)
    {
        $cta = Cta::find($id);
        $headerChild = Header::with('children')->whereNull('parent_id')->where('category', 'Services')->get();
        $headerChild = HeaderResource::collection($headerChild);
        $links = Header::where('link', '!=', '')->get();

        return view('Cta.cta', compact('cta', 'headerChild', 'links'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:100|max:2000',
            'button_content' => 'nullable|string|max:255',
            'button_link' => 'nullable|required_with:button_content',
        ], [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title must not exceed 255 characters.',
            'button_link.required_with' => 'The button link is required when button content is provided.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a valid string.',
            'description.min' => 'The description must be at least 100 characters.',
            'description.max' => 'The description must not exceed 2000 characters.',
        ]);

        $cta = Cta::findOrFail($request->hidden_id);

        $cta->title = $request->title;
        $cta->cta_type = $request->cta_type;

        switch ($request->type) {
            case 'Home':
                $url_type = '/';
                $url_page = $request->type;
                break;
            case 'ADHD':
                $url_type = 'adhd';
                $url_page = $request->type;
                break;
            case 'Autism':
                $url_type = 'autism';
                $url_page = $request->type;
                break;
            case 'Assessment':
                $url_type = 'assessment';
                $url_page = $request->type;
                break;
            case 'Fees':
                $url_type = 'fee';
                $url_page = $request->type;
                break;
            case 'About Us':
                $url_type = 'about';
                $url_page = $request->type;
                break;
            case 'Our Approach':
                $url_type = 'our-approach';
                $url_page = $request->type;
                break;
            case 'Accreditation & Certifications':
                $url_type = 'accreditation';
                $url_page = $request->type;
                break;
    
            default:
                $url_type = null;
                $url_page = null;
                break;
        }
        $cta->page = $url_page;
        $cta->url = $url_type;
        $cta->button_content = $request->button_content;
        $cta->button_link = $request->button_link;
        $cta->description = $request->description;
        $cta->status = $request->status ?? "off";

        $cta->save();
        return redirect()->route('cta.index')->with('success', 'Record updated successfully!');
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
