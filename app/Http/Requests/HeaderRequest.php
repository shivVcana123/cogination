<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeaderRequest extends FormRequest
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
            'category' => [
                'required',
                'max:255',
                Rule::unique('headers', 'category')->ignore($this->header_id),
            ],
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:headers,id',
        ];
    }
    public function messages()
    {
        return [
            'category.required' => 'Please enter your category.',
        ];
    }
}
