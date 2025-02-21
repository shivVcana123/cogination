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

    public function deleteEmails(Request $request)
    {
        if ($request->has('id')) {
            // Single delete
            NewsletterSubscription::where('id', $request->id)->delete();
        } elseif ($request->has('ids')) {
            // Bulk delete
            NewsletterSubscription::whereIn('id', $request->ids)->delete();
        }
        return redirect()->back()->with('success', 'Record deleted successfully.');
    }
    
}
