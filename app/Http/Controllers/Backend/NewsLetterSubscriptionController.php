<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NewsLetterSection;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsLetterSubscriptionController extends Controller
{
    public function subscribeNewsletter()
    {
        $subscribeNewsletter = NewsletterSubscription::get();

        return view('news-lettere-section.index', compact('subscribeNewsletter'));
    }

    public function newsLetterForm()
    {
        $subscribeNewsletter = NewsLetterSection::first();

        return view('news-lettere-section.form', compact('subscribeNewsletter'));
    }

    public function newsLetterSave(Request $request)
    {

            $validated = $request->validate([
                'title' => 'required',
                'button_content' => 'required',
            ], [
                'title.required' => 'The title field is required.',
                'button_content.required' => 'The title field is required.',
            
            ]);
            // Fetch or create a new section
            $newsletter = $request->hidden_id
                ? NewsLetterSection::findOrFail($request->hidden_id)
                : new NewsLetterSection();
    
            $pointers = [];
    
            // Process pointers if present
            if (!empty($request->link)) {
                foreach ($request->link as $index => $linkData) {
                    $subImagePath = null;
    
                    // Handle image upload if provided
                    if (isset($request->file('image')[$index]) && $request->file('image')[$index]->isValid()) {
                        $imageName = time() . '_' . $request->file('image')[$index]->getClientOriginalName();
                        $subImagePath = $request->file('image')[$index]->storeAs('adhd', $imageName, 'public');
                        $subImagePath = 'storage/' . $subImagePath;
                    } elseif ($newsletter->pointers) {
                        // Use existing image if no new image is provided
                        $existingPointers = json_decode($newsletter->pointers, true);
                        $subImagePath = $existingPointers[$index]['image'] ?? null;
                    }
    
                    // Append pointer data
                    $pointers[] = [
                        'link' => $linkData,
                        'image' => $subImagePath,
                    ];
                }
            }
    
            // Assign general data
            $newsletter->title = $request->title;
            $newsletter->button_content = $request->button_content;
            // $newsletter->button_link = $request->button_link;
            $newsletter->pointers = json_encode($pointers); // Save pointers as JSON
    
            // Save the model
            $newsletter->save();
    
            // Redirect with success message
            return redirect()->route('news-letter-form')->with('success', 'Newsletter details saved successfully.');
        
    }
    
    
    

    // public function newsLetterSave(Request $request)
    // {

    //     dd($request->all());
    //     // Validate incoming request
    //     // $validated = $request->validate([
    //     //     'title' => 'nullable|string|max:255',
    //     //     'button_content' => 'nullable|string|max:255',
    //     //     'button_link' => 'nullable|string|max:255',
    //     //     'image.*' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
    //     //     'link.*' => 'nullable|string|max:255',
    //     //     'status' => 'nullable|in:on,off',
    //     // ]);
    
    //     // Fetch or create a new section
    //     $newsletter = $request->hidden_id
    //         ? NewsLetterSection::findOrFail($request->hidden_id)
    //         : new NewsLetterSection();
    
    //     $pointers = [];
    
    //     // Handle image and link input
    //     if (!empty($request->image)) {
    //         foreach ($request->image as $index => $subTitle) {
    //             $iconPath = null;
    
    //             // Check if file exists for the current index and is valid
    //             if ($request->hasFile("image.$index") && $request->file("image.$index")->isValid()) {
    //                 $file = $request->file("image.$index");
    //                 $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //                 $filePath = $file->storeAs('newsletter', $fileName, 'public'); // Store in 'newsletter' directory
    //                 $iconPath = 'storage/' . $filePath; // Format as 'storage/newsletter/<file_name>'
    //             }
    
    //             // Add pointer data if image or link exists
    //             $pointers[] = [
    //                 'image' => $iconPath,
    //                 'link' => $request->link[$index] ?? null,
    //             ];
    //         }
    //     }
    
    //     // Assign data to the newsletter model
    //     $newsletter->title = $request->title;
    //     $newsletter->button_content = $request->button_content;
    //     $newsletter->button_link = $request->button_link;
    //     $newsletter->pointers = json_encode($pointers); // Encode pointers as JSON
    //     $newsletter->status = $request->status ?? "off";
    //     $newsletter->save();
    
    //     // Redirect with success message
    //     return redirect()->route('news-letter-form')->with('success', 'Newsletter details saved successfully.');
    // }
    
    // public function newsLetterSave(Request $request)
    // {
    //     // $validated = $request->validate([
    //     //     'title' => 'nullable|string|max:255',
    //     //     'button_content' => 'nullable|string|max:255',
    //     //     'button_link' => 'nullable',
    //     //     'image.*' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
    //     //     'link.*' => 'nullable',
    //     //     'status' => 'nullable|in:on,off',
    //     // ]);
    //     dd($request->all());

    //     // Fetch or create a new section
    //     $newsletter = $request->hidden_id
    //         ? NewsLetterSection::find($request->hidden_id)
    //         : new NewsLetterSection();


    //         $pointers = [];

    //         if (!empty($request->image)) {
    //             foreach ($request->image as $index => $subTitle) {
    //                 $iconPath = null; 
            
    //                 if ($request->hasFile("image.$index") && $request->file("image.$index")->isValid()) {
    //                     $file = $request->file("image.$index");
    //                     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //                     $filePath = $file->storeAs('newsletter', $fileName, 'public');
    //                     $iconPath = 'storage/' . $filePath;
    //                 }
     
    //                 // Only update pointer if image value exists
    //                 if (!is_null($iconPath)) {
    //                     $pointers[] = [
    //                         'image' => $iconPath,
    //                         'link' => $request->link[$index] ?? null,
    //                     ];
    //                 }
    //             }
    //         }
            
    //         // dd($pointers);
    //     // if ($request->has('link')) {
    //     //     foreach ($request->link as $index => $link) {
    //     //         $iconPath = null;

    //     //         // Check if file exists for the current index and is valid
    //     //         if ($request->hasFile("image.$index") && $request->file("image.$index")->isValid()) {
    //     //             $file = $request->file("image.$index");
    //     //             $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //     //             $filePath = $file->storeAs('newsletter', $fileName, 'public'); // Save in 'banner' directory
    //     //             $iconPath = 'storage/' . $filePath; // Format as 'storage/banner/<file_name>'
    //     //         }

    //     //         $pointers[] = [
    //     //             'image' => $iconPath,
    //     //             'link' => $link,
    //     //         ];
    //     //     }
    //     // }

    //     // Assign data
    //     $newsletter->title = $request->title;
    //     $newsletter->button_content = $request->button_content;
    //     $newsletter->button_link = $request->button_link;
    //     $newsletter->pointers = json_encode($pointers); // Use generated pointers
    //     $newsletter->status = $request->status ?? "off";
    //     $newsletter->save();

    //     return redirect()->route('news-letter-form')->with('success', 'Newsletter details saved successfully.');
    // }
}
