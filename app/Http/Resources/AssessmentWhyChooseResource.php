<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentWhyChooseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'first_button_content' => $this->first_button_content,
            'first_button_link' => $this->first_button_link,
            'second_button_content' => $this->second_button_content,
            'second_button_link' => $this->second_button_link,
            'image' => $this->image,
            'pointers' => $this->pointers,
        ];
    }
}
