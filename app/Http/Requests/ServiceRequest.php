<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
             'background_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
             'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
             'title' => 'required|string|max:255',
             'subtitle' => 'nullable|string|max:255', 
            
         ];
     }
     
 
     public function messages()
     {
         return [
             'background_image.image' => 'The background image must be a valid image file.',
             'background_image.mimes' => 'The background image must be a file of type: jpg, jpeg, png, gif.',
             'image.image' => 'The image must be a valid image file.',
             'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif.',
             'title.required' => 'Please enter your title.',
             'subtitle.required' => 'Please enter your subtitle.', // Optional if subtitle is nullable
            
         ];
     }
     
}
