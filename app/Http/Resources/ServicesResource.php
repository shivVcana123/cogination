<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
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
            'service_type' => $this->service_type,
            'description_1' => $this->description_1,
            'description_2' => $this->description_2,
            'button_content' => $this->button_content,
            'button_link' => $this->button_link,
            'image' => $this->image,
            'background_image' => $this->background_image,
            'background_color' => $this->background_color,
            'pointers' => json_decode($this->pointers),
        ];
    }
}
