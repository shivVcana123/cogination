<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageDesignRequest extends FormRequest
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
             'header_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
             'footer_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
             'title_style' => 'required',
             'subtitle_style' => 'required', 
             'description_style' => 'required',
             'button_content_style' => 'required',
             'header_color' => 'required',
             'footer_color' => 'required',
         ];
     }
     
 
     public function messages()
     {
         return [
             'header_image.image' => 'The background image must be a valid image file.',
             'header_image.mimes' => 'The background image must be a file of type: jpg, jpeg, png, gif.',
             'footer_image.image' => 'The image must be a valid image file.',
             'footer_image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif.',
             'title_style.required' => 'Please enter your title style.',
             'subtitle_style.required' => 'Please enter your subtitle style.', 
             'description_style.required' => 'Please enter your description style.', 
             'button_content_style.required' => 'Please enter your button content style .',
             'header_color.required' => 'Please enter your header color.',
             'footer_color.required' => 'Please enter your footer color.',
         ];
     }
}
