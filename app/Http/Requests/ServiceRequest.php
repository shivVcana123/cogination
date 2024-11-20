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
             'service_type' => 'required',
             'description_1' => 'required|string',
             'description_2' => 'required|string',
             'button_content' => 'required|string|max:255',
             'button_link' => 'required|string',
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
             'service_type.required' => 'Please select service type.', // Optional if subtitle is nullable
             'description_1.required' => 'Please enter your description 1.',
             'description_2.required' => 'Please enter your description 2.',
             'button_content.required' => 'Button text is required.',
             'button_link.required' => 'Please enter your button link.',
         ];
     }
     
}
