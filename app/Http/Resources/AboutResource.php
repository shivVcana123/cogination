<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
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
            'button_content' => $this->button_content,
            'button_link' => $this->button_link,
            'first_image' => $this->first_image,
            'second_image' => $this->second_image,
            'status' => $this->status,
            
        ];
    }
}
