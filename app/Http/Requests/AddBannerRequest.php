<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     public function rules(): array
     {
         return [
             'type' => 'required|string|max:255',
             'heading' => 'required|string|max:255',
             'subtitle' => 'nullable|string|max:255',
             'description' => 'required|string',
             'section_banner' => [
                 'nullable', // Default to nullable
                 'required_if:type,Home', // Required if `type` is "Home"
                 'string', // Must be a string if present
             ],
             'section_type' => [
                 'nullable', // Default to nullable
                 'required_if:type,ADHD,Autism', // Required if `type` is "ADHD" or "Autism"
                 'string', // Must be a string if present
             ],
             'button_text' => 'nullable|string|max:255',
             'button_link' => 'nullable|required_with:button_text', // Required if button_text is present
             'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,svg', // Max size 2MB
         ];
     }
     
     public function messages()
     {
         return [
             'type.required' => 'The banner type is required.',
             'type.string' => 'The banner type must be a valid string.',
             'type.max' => 'The banner type must not exceed 255 characters.',
             'heading.required' => 'The heading is required.',
             'heading.string' => 'The heading must be a valid string.',
             'heading.max' => 'The heading must not exceed 255 characters.',
             'subtitle.string' => 'The subtitle must be a valid string.',
             'subtitle.max' => 'The subtitle must not exceed 255 characters.',
             'description.required' => 'The description is required.',
             'section_banner.required_if' => 'The section banner is required when the type is Home.',
             'section_type.required_if' => 'The section type is required when the type is ADHD or Autism.',
             'button_text.string' => 'The button text must be a valid string.',
             'button_text.max' => 'The button text must not exceed 255 characters.',
             'button_link.url' => 'The button link must be a valid URL.',
             'button_link.max' => 'The button link must not exceed 255 characters.',
             'button_link.required_with' => 'The button link is required when button text is present.',
             'image.required' => 'An image is required.',
             'image.image' => 'The uploaded file must be an image.',
             'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif, webp, svg.',
         ];
     }
     

}
